<?php

namespace AppBundle\Controller\Front;

use AppBundle\Manager\KategoriManager;
use AppBundle\Manager\KategoriNewsManager;
use AppBundle\Manager\KategoriPartManager;
use AppBundle\Manager\SettingManager;
use JMS\DiExtraBundle\Annotation\Inject;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TemplateController
 *
 * @package AppBundle\Controller\Front
 */
class TemplateController extends Controller
{
    /**
     * @var SettingManager
     * @Inject("manager.setting")
     */
    private $settingManager;

    /**
     * @var KategoriManager
     * @Inject("manager.kategori")
     */
    private $kategoriManager;

    /**
     * @var KategoriPartManager
     * @Inject("manager.kategoriPart")
     */
    private $kategoriPartManager;

    /**
     * @var KategoriNewsManager
     * @Inject("manager.kategoriNews")
     */
    private $kategoriNewsManager;

    public function headerAction($currentPath, $currentUrl, Request $request)
    {
        $teleponSetting = $this->settingManager->getTeleponSetting();
        $kategoris      = $this->kategoriManager->findAllAktif();
        $kategoriParts  = $this->kategoriPartManager->findAllAktif();
        $kategoriNewss  = $this->kategoriNewsManager->findAllAktif();

        return $this->render('AppBundle:Front:Template/header.html.twig', [
            'teleponSetting' => $teleponSetting,
            'kategoris'      => $kategoris,
            'kategoriParts'  => $kategoriParts,
            'kategoriNewss'  => $kategoriNewss,
            'currentPath'    => $currentPath,
            'currentUrl'     => $currentUrl
        ]);
    }

    public function footerAction($currentPath, $currentUrl, Request $request)
    {
        $teleponSetting = $this->settingManager->getTeleponSetting();
        $emailSetting   = $this->settingManager->getEmailSetting();
        $kategoris      = $this->kategoriManager->findAllAktif();
        $kategoriParts  = $this->kategoriPartManager->findAllAktif();

        return $this->render('AppBundle:Front:Template/footer.html.twig', [
            'teleponSetting' => $teleponSetting,
            'emailSetting'   => $emailSetting,
            'kategoris'      => $kategoris,
            'kategoriParts'  => $kategoriParts,
            'currentPath'    => $currentPath,
            'currentUrl'     => $currentUrl
        ]);
    }
}
