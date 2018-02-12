<?php

namespace AppBundle\Controller\Secured;

use AppBundle\Entity\Setting;
use AppBundle\Manager\SettingManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator;

/**
 * @Route("/setting", name="app_secured_setting")
 */
class SettingController extends Controller
{
    /**
     * @var Validator
     * @Inject("validator")
     */
    private $validator;

    /**
     * @var Serializer
     * @Inject("serializer")
     */
    private $serializer;

    /**
     * @var SettingManager
     * @Inject("manager.setting")
     */
    private $settingManager;

    // ================================================================================= Tentang

    /**
     * @Route("/tentang", name="app_secured_setting_tentang", methods={"GET"})
     */
    public function tentangAction(Request $request)
    {
        return $this->render('AppBundle:Secured/Setting:tentang.html.twig', []);
    }

    /**
     * @Route("/tentang", name="app_secured_setting_tentang_post", methods={"POST"})
     */
    public function tentangPostAction(Request $request)
    {
        $setting = [
            "tentang" => $this->settingManager->getTentangSetting()
        ];

        $response = [
            'result'  => 'error',
            'setting' => null,
            'errors'  => []
        ];

        if (!is_null($request->request->get('tentang'))) {
            $setting["tentang"]->setSettingValue($request->request->get('tentang'));
        }

        $errorList            = [];
        $errorList['tentang'] = $this->validator->validate($setting['tentang'], ['Default']);

        foreach ($errorList as $key => $error) {
            if (count($error)) {
                foreach ($error as $tmp) {
                    /** @var ConstraintViolation $tmp */
                    $response['errors'][$key] = $tmp->getMessage();
                }
            }
        }

        if (count($response['errors']) == 0) {
            $this->settingManager->save($setting['tentang']);

            $response['setting'] = json_decode($this->serializer->serialize($setting, 'json'));
            $response['result']  = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/tentang/get", name="app_secured_setting_tentang_get")
     */
    public function tentangGetAction(Request $request)
    {
        $setting = [
            "tentang" => $this->settingManager->getTentangSetting(),
        ];

        return new Response($this->serializer->serialize($setting, 'json'));
    }

    // ================================================================================= Service

    /**
     * @Route("/service", name="app_secured_setting_service", methods={"GET"})
     */
    public function serviceAction(Request $request)
    {
        return $this->render('AppBundle:Secured/Setting:service.html.twig', []);
    }

    /**
     * @Route("/service", name="app_secured_setting_service_post", methods={"POST"})
     */
    public function servicePostAction(Request $request)
    {
        $setting = [
            "service" => $this->settingManager->getServiceSetting()
        ];

        $response = [
            'result'  => 'error',
            'setting' => null,
            'errors'  => []
        ];

        if (!is_null($request->request->get('service'))) {
            $setting["service"]->setSettingValue($request->request->get('service'));
        }

        $errorList            = [];
        $errorList['service'] = $this->validator->validate($setting['service'], ['Default']);

        foreach ($errorList as $key => $error) {
            if (count($error)) {
                foreach ($error as $tmp) {
                    /** @var ConstraintViolation $tmp */
                    $response['errors'][$key] = $tmp->getMessage();
                }
            }
        }

        if (count($response['errors']) == 0) {
            $this->settingManager->save($setting['service']);

            $response['setting'] = json_decode($this->serializer->serialize($setting, 'json'));
            $response['result']  = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/service/get", name="app_secured_setting_service_get")
     */
    public function serviceGetAction(Request $request)
    {
        $setting = [
            "service" => $this->settingManager->getServiceSetting(),
        ];

        return new Response($this->serializer->serialize($setting, 'json'));
    }

    // ================================================================================= Dealer

    /**
     * @Route("/dealer", name="app_secured_setting_dealer", methods={"GET"})
     */
    public function dealerAction(Request $request)
    {
        return $this->render('AppBundle:Secured/Setting:dealer.html.twig', []);
    }

    /**
     * @Route("/dealer", name="app_secured_setting_dealer_post", methods={"POST"})
     */
    public function dealerPostAction(Request $request)
    {
        $setting = [
            "dealer" => $this->settingManager->getDealerSetting()
        ];

        $response = [
            'result'  => 'error',
            'setting' => null,
            'errors'  => []
        ];

        if (!is_null($request->request->get('dealer'))) {
            $setting["dealer"]->setSettingValue($request->request->get('dealer'));
        }

        $errorList           = [];
        $errorList['dealer'] = $this->validator->validate($setting['dealer'], ['Default']);

        foreach ($errorList as $key => $error) {
            if (count($error)) {
                foreach ($error as $tmp) {
                    /** @var ConstraintViolation $tmp */
                    $response['errors'][$key] = $tmp->getMessage();
                }
            }
        }

        if (count($response['errors']) == 0) {
            $this->settingManager->save($setting['dealer']);

            $response['setting'] = json_decode($this->serializer->serialize($setting, 'json'));
            $response['result']  = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/dealer/get", name="app_secured_setting_dealer_get")
     */
    public function dealerGetAction(Request $request)
    {
        $setting = [
            "dealer" => $this->settingManager->getDealerSetting(),
        ];

        return new Response($this->serializer->serialize($setting, 'json'));
    }

    // ================================================================================= Kontak

    /**
     * @Route("/kontak", name="app_secured_setting_kontak", methods={"GET"})
     */
    public function kontakAction(Request $request)
    {
        return $this->render('AppBundle:Secured/Setting:contact.html.twig', []);
    }

    /**
     * @Route("/kontak", name="app_secured_setting_kontak_post", methods={"POST"})
     */
    public function kontakPostAction(Request $request)
    {
        $setting = [
            "alamat"  => $this->settingManager->getAlamatSetting(),
            "telepon" => $this->settingManager->getTeleponSetting(),
            "fax"     => $this->settingManager->getFaxSetting(),
            "email"   => $this->settingManager->getEmailSetting()
        ];

        $response = [
            'result'  => 'error',
            'setting' => null,
            'errors'  => []
        ];

        if (!is_null($request->request->get('alamat'))) {
            $setting["alamat"]->setSettingValue($request->request->get('alamat'));
        }
        if (!is_null($request->request->get('fax'))) {
            $setting["fax"]->setSettingValue($request->request->get('fax'));
        }
        if (!is_null($request->request->get('telepon'))) {
            $setting["telepon"]->setSettingValue($request->request->get('telepon'));
        }
        if (!is_null($request->request->get('email'))) {
            $setting["email"]->setSettingValue($request->request->get('email'));
        }

        $errorList            = [];
        $errorList['alamat']  = $this->validator->validate($setting['alamat'], ['Default']);
        $errorList['fax']     = $this->validator->validate($setting['fax'], ['Default']);
        $errorList['telepon'] = $this->validator->validate($setting['telepon'], ['Default']);
        $errorList['email']   = $this->validator->validate($setting['email'], ['Default', 'email']);

        foreach ($errorList as $key => $error) {
            if (count($error)) {
                foreach ($error as $tmp) {
                    /** @var ConstraintViolation $tmp */
                    $response['errors'][$key] = $tmp->getMessage();
                }
            }
        }

        if (count($response['errors']) == 0) {
            $this->settingManager->save($setting['alamat']);
            $this->settingManager->save($setting['fax']);
            $this->settingManager->save($setting['telepon']);
            $this->settingManager->save($setting['email']);

            $response['setting'] = json_decode($this->serializer->serialize($setting, 'json'));
            $response['result']  = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/kontak/get", name="app_secured_setting_kontak_get")
     */
    public function kontakGetAction(Request $request)
    {
        $setting = [
            "alamat"  => $this->settingManager->getAlamatSetting(),
            "telepon" => $this->settingManager->getTeleponSetting(),
            "fax"     => $this->settingManager->getFaxSetting(),
            "email"   => $this->settingManager->getEmailSetting()
        ];

        return new Response($this->serializer->serialize($setting, 'json'));
    }

    /**
     * @Route("/kontak2", name="app_secured_setting_kontak2_post", methods={"POST"})
     */
    public function kontak2PostAction(Request $request)
    {
        $setting = [
            "kunjungiKami"   => $this->settingManager->getKunjungiKamiSetting(),
            "jamOperasional" => $this->settingManager->getJamOperasionalSetting()
        ];

        $response = [
            'result'  => 'error',
            'setting' => null,
            'errors'  => []
        ];

        if (!is_null($request->request->get('kunjungiKami'))) {
            $setting["kunjungiKami"]->setSettingValue($request->request->get('kunjungiKami'));
        }
        if (!is_null($request->request->get('jamOperasional'))) {
            $setting["jamOperasional"]->setSettingValue($request->request->get('jamOperasional'));
        }

        $errorList                   = [];
        $errorList['kunjungiKami']   = $this->validator->validate($setting['kunjungiKami'], ['Default']);
        $errorList['jamOperasional'] = $this->validator->validate($setting['jamOperasional'], ['Default']);

        foreach ($errorList as $key => $error) {
            if (count($error)) {
                foreach ($error as $tmp) {
                    /** @var ConstraintViolation $tmp */
                    $response['errors'][$key] = $tmp->getMessage();
                }
            }
        }

        if (count($response['errors']) == 0) {
            $this->settingManager->save($setting['kunjungiKami']);
            $this->settingManager->save($setting['jamOperasional']);

            $response['setting'] = json_decode($this->serializer->serialize($setting, 'json'));
            $response['result']  = 'success';
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/kontak2/get", name="app_secured_setting_kontak2_get")
     */
    public function kontak2GetAction(Request $request)
    {
        $setting = [
            "kunjungiKami"   => $this->settingManager->getKunjungiKamiSetting(),
            "jamOperasional" => $this->settingManager->getJamOperasionalSetting()
        ];

        return new Response($this->serializer->serialize($setting, 'json'));
    }

    private function updateSetting(Setting $setting, Request $request)
    {
        $response = [
            'result'  => 'error',
            'setting' => null,
            'errors'  => []
        ];

        $this->settingManager->assignRequest($setting, $request);

        $errorList = $this->validator->validate($setting, ['Default']);

        if (count($errorList)) {
            foreach ($errorList as $error) {
                /** @var ConstraintViolation $error */
                $response['errors'][$error->getPropertyPath()] = $error->getMessage();
            }
        } else {
//            if (!is_null($setting->getFile())) {
//                $uploadableManager = $this->get('stof_doctrine_extensions.uploadable.manager');
//
//                $uploadableManager->markEntityToUpload($setting, $setting->getFile());
//            }

            $this->settingManager->save($setting);

            $response['setting'] = json_decode($this->serializer->serialize($setting, 'json'));
            $response['result']  = 'success';
        }

        return new JsonResponse($response);
    }
}
