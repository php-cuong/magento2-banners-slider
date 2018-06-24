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

namespace PHPCuong\BannerSlider\Model\Group\Config\Source;

use Magento\Framework\Escaper;
use PHPCuong\BannerSlider\Model\GroupFactory as BannerGroupFactory;

class Options implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var BannerGroupFactory
     */
    protected $bannerGroupFactory;

    /**
     * Escaper
     *
     * @var Escaper
     */
    protected $escaper;

    /**
     * Constructor
     *
     * @param BannerGroupFactory $systemStore
     * @param Escaper $escaper
     */
    public function __construct(BannerGroupFactory $bannerGroupFactory, Escaper $escaper)
    {
        $this->bannerGroupFactory = $bannerGroupFactory;
        $this->escaper = $escaper;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->getAvailableGroups();
    }

    /**
     * Prepare groups
     *
     * @return array
     */
    private function getAvailableGroups()
    {
        $collection = $this->bannerGroupFactory->create()->getCollection();
        $result = [];
        $result[] = ['value' => ' ', 'label' => 'Select...'];
        foreach ($collection as $group) {
            $result[] = ['value' => $group->getId(), 'label' => $this->escaper->escapeHtml($group->getName())];
        }
        return $result;
    }
}
