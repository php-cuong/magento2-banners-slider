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

namespace PHPCuong\BannerSlider\Model;

use Magento\Framework\Exception\LocalizedException;

class Group extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Group cache tag
     */
    const CACHE_TAG = 'phpcuong_banners_slider_group';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('PHPCuong\BannerSlider\Model\ResourceModel\Group');
    }

    /**
     * Processing object before save data
     *
     * @return $this
     */
    public function beforeSave()
    {
        $groupName = $this->getData('name');
        $groupId = (int)$this->getData('id');
        $collection = $this->getCollection()->addFieldToFilter('name', $groupName);
        if ($groupId) {
            $collection = $collection->addFieldToFilter('id', ['neq' => $groupId]);
        }
        $group = $collection->getFirstItem();
        if ($group->getId()) {
            throw new LocalizedException(__('The Group Name has already existed.'));
        }
        parent::beforeSave();
        return $this;
    }
}
