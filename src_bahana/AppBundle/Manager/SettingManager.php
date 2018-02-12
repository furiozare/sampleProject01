<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Setting;
use AppBundle\Repository\SettingRepository;
use Doctrine\ORM\EntityManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Service(id="manager.setting")
 */
class SettingManager
{

    const SETTING_TENTANG_KEY = 1;
    const SETTING_SERVICE_KEY = 2;
    const SETTING_DEALER_KEY = 3;

    const SETTING_ALAMAT_KEY = 10;
    const SETTING_TELEPON_KEY = 11;
    const SETTING_FAX_KEY = 12;
    const SETTING_KUNJUNGI_KAMI_KEY = 13;
    const SETTING_JAM_OPERASIONAL_KEY = 14;
    const SETTING_EMAIL_KEY = 15;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var SettingRepository
     */
    private $settingRepository;

    /**
     * @InjectParams({
     *      "entityManager" = @Inject("doctrine.orm.default_entity_manager")
     * })
     */
    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->settingRepository = $this->entityManager->getRepository("AppBundle:Setting");
    }

    public function assignRequest(Setting $setting, Request $request)
    {
        if (!is_null($request->request->get('value'))) {
            $setting->setSettingValue($request->request->get('value'));
        }
    }

    public function getTentangSetting()
    {
        return $this->findOneOrNewBySettingKey(self::SETTING_TENTANG_KEY);
    }

    public function getServiceSetting()
    {
        return $this->findOneOrNewBySettingKey(self::SETTING_SERVICE_KEY);
    }

    public function getDealerSetting()
    {
        return $this->findOneOrNewBySettingKey(self::SETTING_DEALER_KEY);
    }

    public function getAlamatSetting()
    {
        return $this->findOneOrNewBySettingKey(self::SETTING_ALAMAT_KEY);
    }

    public function getFaxSetting()
    {
        return $this->findOneOrNewBySettingKey(self::SETTING_FAX_KEY);
    }

    public function getTeleponSetting()
    {
        return $this->findOneOrNewBySettingKey(self::SETTING_TELEPON_KEY);
    }

    public function getKunjungiKamiSetting()
    {
        return $this->findOneOrNewBySettingKey(self::SETTING_KUNJUNGI_KAMI_KEY);
    }

    public function getJamOperasionalSetting()
    {
        return $this->findOneOrNewBySettingKey(self::SETTING_JAM_OPERASIONAL_KEY);
    }

    public function getEmailSetting()
    {
        return $this->findOneOrNewBySettingKey(self::SETTING_EMAIL_KEY);
    }

    public function findOneOrNewBySettingKey($settingKey)
    {
        $query  = $this->settingRepository->queryFindBySettingKey($settingKey)->getQuery();
        $result = $query->getOneOrNullResult();

        if (is_null($result)) {
            $result = new Setting();
            $result->setSettingKey($settingKey);
        }

        return $result;
    }

    public function remove(Setting $setting)
    {
        $this->entityManager->remove($setting);
        $this->entityManager->flush();
    }

    public function save(Setting $setting)
    {
        if (!$setting->getId()) {
            $this->entityManager->persist($setting);
        }
        $this->entityManager->flush();
    }
}
