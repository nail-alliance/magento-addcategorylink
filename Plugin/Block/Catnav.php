<?php
namespace Nailalliance\AddCategoryLink\Plugin\Block;

use Magento\Framework\Data\Tree\NodeFactory;

class Catnav
{
    public function __construct(
        NodeFactory $nodeFactory,
        \Magento\Framework\UrlInterface $urlInterface
    ) {
        $this->nodeFactory = $nodeFactory;
        $this->urlInterface = $urlInterface;
    }

    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject,
        $outermostClass = '',
        $childrenWrapClass = '',
        $limit = 0
    ) {
        $node = $this->nodeFactory->create(
            [
                'data' => $this->getNodeAsArray(),
                'idField' => 'id',
                'tree' => $subject->getMenu()->getTree()
            ]
        );
        $subject->getMenu()->addChild($node);
    }

    public function getNodeAsArray()
    {
        return [
            'name' => __('Education'),
            'id' => 'brand-educators-menu',
            'url' => $this->urlInterface->getUrl('https://gelishmorgantaylor.education/'),
            'target' => '_blank',
            'has_active' => false,
            'is_active' => $this->isActive()
        ];
    }
    
    private function isActive()
    {
        $activeUrls = 'https://gelishmorgantaylor.education/';
        $currentUrl = $this->urlInterface->getCurrentUrl();
        if (strpos($currentUrl, $activeUrls) !== false) {
            return true;
        }
        return false;
    }
}