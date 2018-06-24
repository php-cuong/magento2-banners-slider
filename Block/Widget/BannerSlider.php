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

namespace PHPCuong\BannerSlider\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class BannerSlider extends Template implements BlockInterface
{
    /**
     * @var \PHPCuong\BannerSlider\Model\BannerFactory
     */
    protected $bannerFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \PHPCuong\BannerSlider\Model\BannerFactory $bannerFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \PHPCuong\BannerSlider\Model\BannerFactory $bannerFactory,
        array $data = []
    ) {
        $this->bannerFactory = $bannerFactory;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve the banners slider
     *
     * @param \PHPCuong\BannerSlider\Model\Banner[]
     */
    public function getBanners()
    {
        $groupId = (int)$this->getGroupId();
        $collection = $this->bannerFactory->create()->getCollection()->addFieldToFilter(
            'group_id', $groupId
        )->addFieldToFilter(
            'status', \PHPCuong\BannerSlider\Model\Banner::STATUS_ENABLED
        )->setOrder('main_table.order', 'ASC');
        return $collection;
    }
}
