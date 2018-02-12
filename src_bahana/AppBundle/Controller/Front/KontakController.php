<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\BookingKontak;
use AppBundle\Entity\Kontak;
use AppBundle\Manager\BookingKontakManager;
use AppBundle\Manager\KontakManager;
use AppBundle\Manager\SettingManager;
use JMS\DiExtraBundle\Annotation\Inject;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * Class KontakController
 *
 * @package AppBundle\Controller\Front
 *
 * @Route(path="/kontak", name="app_kontak")
 */
class KontakController extends Controller
{
    /**
     * @var SettingManager
     * @Inject("manager.setting")
     */
    private $settingManager;

    /**
     * @var KontakManager
     * @Inject("manager.kontak")
     */
    private $kontakManager;

    /**
     * @Route(path="/", name="app_kontak_index", methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        $alamat         = $this->settingManager->getAlamatSetting();
        $fax            = $this->settingManager->getFaxSetting();
        $telepon        = $this->settingManager->getTeleponSetting();
        $kunjungiKami   = $this->settingManager->getKunjungiKamiSetting();
        $jamOperasional = $this->settingManager->getJamOperasionalSetting();

        return $this->render('AppBundle:Front/Kontak:index.html.twig', [
            'alamat'         => $alamat,
            'fax'            => $fax,
            'telepon'        => $telepon,
            'kunjungiKami'   => $kunjungiKami,
            'jamOperasional' => $jamOperasional,
        ]);
    }

    /**
     * @Route(path="/demo", name="app_kontak_demo", methods={"GET"})
     */
    public function demoAction(Request $request)
    {
        $kontak = $this->kontakManager->findOneById(1);

        return $this->render('@App/Front/Email/kontakDiterimaEmail.html.twig', [
            'kontak' => $kontak,
        ]);
    }

    /**
     * @Route("/", name="app_kontak_save", methods={"POST"})
     */
    public function saveAction(Request $request)
    {
        $response = [
            'result' => 'error',
            'kontak' => null,
            'errors' => []
        ];

        $kontak = new Kontak();

        $this->kontakManager->assignRequest($kontak, $request);

        $errorList = $this->get('validator')->validate($kontak, ['create', 'Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
            $this->kontakManager->save($kontak);

            $message = \Swift_Message::newInstance()
                ->setSubject('Pesan telah diterima')
                ->setFrom('noreply@bahanayamaha.com')
                ->setTo($kontak->getEmail())
                ->setReplyTo("support@bahanayamaha.com")
                ->setCc('support@bahanayamaha.com')
                ->setBcc('ehs.hantan@gmail.com')
                ->setBody(
                    $this->renderView(
                        'AppBundle:Front/Email:kontakDiterimaEmail.html.twig',
                        [
                            'kontak' => $kontak
                        ]
                    ),
                    'text/html'
                );

            $message->getHeaders()->addIdHeader("Message-ID", time() . "system@bahanayamaha.com");
            $message->getHeaders()->addTextHeader('MIME-Version', '1.0');
            $message->getHeaders()->addTextHeader('X-Mailer', 'PHP v' . phpversion());
            $message->getHeaders()->addParameterizedHeader('Content-type', 'text/html', ['charset' => 'utf-8']);

            $this->get('mailer')->send($message);

            $response['result'] = 'success';
        }

        return new JsonResponse($response);
    }
}
