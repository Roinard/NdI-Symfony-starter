<?php


namespace App\Controller;



use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /**
     * @Route("/login", name="login_route")
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {

        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'Security/login.html.twig', array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error' => $error,
            )
        );
    }
    /**
     * @Route("/signin", name="sign_in")
     */
    public function signIn(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        return $this->redirect($this->generateUrl('login_route'));
        $em = $this->getDoctrine()->getManager();

        $isUpdate = false;
        $toUpdateStudent = new Student();
        $toUpdateStudent->setDateupdated(new DateTime());

        $form = $this->createForm(signInType::class, $toUpdateStudent)
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'));

        $form->handleRequest($request);

        //if ($form->isSubmitted() && $form->isValid()) {
        $errorMail = substr_count($toUpdateStudent->getEmail(), '.') == 1 ? false : true;
        if ($errorMail || !filter_var($toUpdateStudent->getEmail() . "@insa-cvl.fr", FILTER_VALIDATE_EMAIL)) {
            if ($toUpdateStudent->getEmail() != "")
                $this->get('session')->getFlashBag()->add(
                    'danger', "L'adresse mail entrée n'est pas valide."
                );
            return $this->render('Security/signin.html.twig', array('form' => $form->createView()));
        }
        if ($em->getRepository('App:Student')->findOneByEmail($toUpdateStudent->getEmail())) {
            $this->get('session')->getFlashBag()->add(
                'danger', "L'adresse mail entrée est déjà utilisée."
            );
            return $this->render('Student/add.html.twig', array('form' => $form->createView(),
                "edit" => $isUpdate, 'student' => $toUpdateStudent,
                "allSkills" => $allSkills, "notAdmin" => ($toUpdateStudent->getUsername() != "admin")));
        }


        $encoder = $passwordEncoder;

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $pass = '';
        for ($i = 0; $i < 10; $i++) {
            $pass .= $characters[rand(0, $charactersLength - 1)];
        }

        $newPass = $encoder->encodePassword($toUpdateStudent, $pass);
        $studentFolder = new Folder();
        $studentFolder->setParent($em->getRepository('App:Folder')->findByRef("students")[0]);
        $explodedName = explode(".", $toUpdateStudent->getEmail());
        $folderName = substr($explodedName[0], 0, 1) . $explodedName[1];
        $studentFolder->setName($folderName);
        $studentFolder->setIsProtected(True);
        $toUpdateStudent->setFolder($studentFolder);
        $em->persist($studentFolder);
        $toUpdateStudent->setPassword($newPass);

        $toUpdateStudent->setRole('user');
        $toUpdateStudent->setInterest('unknow');
        $em->persist($toUpdateStudent);
        $em->flush();
        $message = $message = (new Swift_Message('[Iris INSA] Nouveau compte Arpège'))
            ->setFrom(array('no-reply@iris-insa.com' => 'Iris INSA'))
            ->setTo($toUpdateStudent->getEmail() . "@insa-cvl.fr")
            ->setBody(
                $this->renderView(
                    'Emails/newAccount.html.twig',
                    array('student' => $toUpdateStudent, 'pass' => $pass)
                ),
                'text/html'
            );
        $mailer->send($message);

        $this->get('session')->getFlashBag()->add(
            'success', "Utilisateur $folderName enregistré."
        );
        return $this->redirect($this->generateUrl('login_route'));
        /*}
          else
          {
          $this->get('session')->getFlashBag()->add(
          'danger', "old :: $toUpdateStudent->oldPass, new :: $toUpdateStudent->newPass"
          );

          }
          return $this->render('Security:signin.html.twig', array('form' => $form->createView()));*/
    }


    /**
     * @Route("/resetpass/{givenToken}", name="resetpw", defaults={"givenToken"=""})
     */
    public function resetPass(UserPasswordEncoderInterface $passwordEncoder, Request $request, $givenToken)
    {
        $em = $this->getDoctrine()->getManager();
        if ($givenToken === "") {
            $student = new Student();
            $form = $this->createForm(ResetPassType::class, $student)
                ->add('save', SubmitType::class, array('label' => 'Renvoyer'));
            $form->handleRequest($request);
        } else {
            $passToken = $em->getRepository('App:PassToken')->findOneByToken($givenToken);
            if (is_null($passToken) || $passToken->getDateValidity() < new DateTime()) {
                $this->get('session')->getFlashBag()->add(
                    'danger', "Le token fourni n'existe pas."
                );
                return $this->redirect($this->generateUrl('login_route'));
            } else {
                $defaultData = array();
                $formBuilder = $this->createFormBuilder($defaultData);
                $form = $formBuilder->add('newpass1', PasswordType::class, array('label' => 'Nouveau mot de passe'))
                    ->add('newpass2', PasswordType::class, array('label' => 'Confirmation'))
                    ->add('save', SubmitType::class, array('label' => 'Enregistrer'))
                    ->getForm();

                $form->handleRequest($request);
            }
        }
        if ($form->isSubmitted()) {
            if ($givenToken !== "") {
                $passToken = $em->getRepository('App:PassToken')->findOneByToken($givenToken);
                if (!$passToken && $passToken->getDateValidity() < new DateTime()) {
                    $this->get('session')->getFlashBag()->add(
                        'danger', "Le token fourni n'existe pas."
                    );
                    return $this->redirect($this->generateUrl('login_route'));
                }
                $student = $passToken->getStudent();
                $encoder = $passwordEncoder;

                $data = $form->getData();
                if ($data['newpass1'] === $data['newpass2']) {
                    $newPass = $encoder->encodePassword($student, $data['newpass1']);
                    $student->setPassword($newPass);
                    $student->setPassToken(null);
                    $em->remove($passToken);
                    $em->flush();
                    $message = (new Swift_Message('Modification de votre mot de passe Arpège'))
                        ->setFrom(array('no-reply@iris-insa.com' => 'Iris INSA'))
                        ->setTo($student->getEmail() . "@insa-cvl.fr")
                        ->setBody(
                            $this->renderView(
                                'Emails/changePass.html.twig',
                                array('student' => $student)
                            ),
                            'text/html'
                        );
                    $mailer->send($message);
                    $this->get('session')->getFlashBag()->add(
                        'success', "Mot de passe modifié !"
                    );
                    return $this->redirect($this->generateUrl('login_route'));

                } else {
                    $this->get('session')->getFlashBag()->add(
                        'danger', "Les deux champs nouveau mot de passe ne sont pas identiques"
                    );
                }
            } elseif (($stu = $em->getRepository('App:Student')->findOneByEmail($student->getEmail()))) {
                $currentDatetime = new DateTime();
                $token = hash("sha256", "" . $stu->getId() . $stu->getEmail() . $stu->getFullName() . $currentDatetime->format('Y-m-d H:i:s'));
                $passToken = new PassToken();
                $passToken->setToken($token);
                $passToken->setdateValidity($currentDatetime->add(new DateInterval('PT1H')));
                if ($stu->getPassToken())
                    $em->remove($stu->getPassToken());
                $passToken->setStudent($stu);
                $stu->setPassToken($passToken);
                $em->persist($passToken);
                $em->persist($stu);
                $em->flush();
                $message = (new Swift_Message('[Iris INSA] Mot de passe Arpège oublié'))
                    ->setFrom(array('no-reply@iris-insa.com' => 'Iris INSA'))
                    ->setTo($stu->getEmail() . "@insa-cvl.fr")
                    ->setBody(
                        $this->renderView(
                            'Emails/newPass.html.twig',
                            array('student' => $stu, 'token' => $token)
                        ),
                        'text/html'
                    );
                $mailer->send($message);
                $this->get('session')->getFlashBag()->add(
                    'success', "Un email a été envoyé à l'adresse indiquée"
                );
                return $this->redirect($this->generateUrl('login_route'));
            } else {
                $this->get('session')->getFlashBag()->add(
                    'danger', "Il n'y a pas de compte enregistré pour cette adresse email."
                );
            }
        }
        return $this->render('Security/resetpw.html.twig', array('form' => $form->createView(), 'token' => $givenToken));
    }

    /**
     * @Route("/signup", name="registration")
     * @param Request $request
     * @param UserPasswordEncoder $encoder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function signupAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        $new_user = new User();
        $new_user->setDateRegistered(new \DateTime());
        $new_user->setDateUpdated(new \DateTime());

        $form = $this->createForm(UserType::class, $new_user)
            ->add('save', SubmitType::class, array('label' => 'Enregistrer'));

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($new_user, $new_user->getPassword());
            $new_user->setPassword($hash);
            $em->persist($new_user);
            $em->flush();

            $this->addFlash("success", "Vous vous êtes inscrits");

            return $this->redirectToRoute("dashboard");
        }
        return $this->render("Security/signup.html.twig", ["form" => $form->createView()]);
    }


    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }

}