<?php
/**
 * GiaPhuGroup Co., Ltd.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the GiaPhuGroup.com license that is
 * available through the world-wide-web at this URL:
 * https://www.giaphugroup.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    PHPCuong
 * @package     PHPCuong_BannerSlider
 * @copyright   Copyright (c) 2018-2019 GiaPhuGroup Co., Ltd. All rights reserved. (http://www.giaphugroup.com/)
 * @license     https://www.giaphugroup.com/LICENSE.txt
 */

namespace PHPCuong\BannerSlider\Model\ResourceModel;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\ObjectManager;
use PHPCuong\BannerSlider\Model\Banner\ImageUploader;

class Banner extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * ImageUploader
     *
     * @var \PHPCuong\BannerSlider\Model\Banner\ImageUploader
     */
    protected $_imageUploader;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('phpcuong_banners_slider', 'id');
    }

    /**
     * Perform actions before object save
     *
     * @param \Magento\Framework\Model\AbstractModel|\Magento\Framework\DataObject $object
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $name = $object->getName();
        $url = $object->getUrl();
        $image = $object->getImage();
        $groupId = $object->getGroupId();
        $order = $object->getOrder();

        if (empty($name)) {
            throw new LocalizedException(__('The banner name is required.'));
        }

        if (is_array($image)) {
            $object->setImage($image[0]['name']);
        }

        // if the URL not null then check the URL
        if (!empty($url) && !filter_var($url, FILTER_VALIDATE_URL)) {
            throw new LocalizedException(__('The URL Link is invalid.'));
        }

        if (!is_numeric($groupId)) {
            throw new LocalizedException(__('The Group Name is required.'));
        }

        if (!empty($order) && !is_numeric($order)) {
            throw new LocalizedException(__('The Sort Order must be a numeric.'));
        }

        return $this;
    }

    /**
     * Perform actions after object delete
     *
     * @param \Magento\Framework\Model\AbstractModel|\Magento\Framework\DataObject $object
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _afterDelete(\Magento\Framework\Model\AbstractModel $object)
    {
        $imageName = $object->getImage();
        $this->_getImageUploader()->deleteImage($imageName);

        return $this;
    }

    /**
     * Get ImageUploader instance
     *
     * @return ImageUploader
     */
    private function _getImageUploader()
    {
        if ($this->_imageUploader === null) {
            $this->_imageUploader = ObjectManager::getInstance()->get(ImageUploader::class);
        }
        return $this->_imageUploader;
    }
}
