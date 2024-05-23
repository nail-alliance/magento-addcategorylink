<?php

namespace Nailalliance\AddCategoryLink\Plugin\Block;

use Magento\Framework\Data\Tree\NodeFactory;
use Magento\Store\Model\StoreManagerInterface;

class Catnav
{
    protected $nodeFactory;
    protected $urlInterface;
    protected $storeManager;

    public function __construct(
        NodeFactory $nodeFactory,
        \Magento\Framework\UrlInterface $urlInterface,
        StoreManagerInterface $storeManager
    ) {
        $this->nodeFactory = $nodeFactory;
        $this->urlInterface = $urlInterface;
        $this->storeManager = $storeManager;
    }

    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject,
        $outermostClass = '',
        $childrenWrapClass = '',
        $limit = 0
    ) {
        $storeCode = $this->storeManager->getStore()->getCode();
        $allowedStores = ['entitybeautyview', 'gelishmorgantaylorview', 'default'];

        if (in_array($storeCode, $allowedStores)) {
            $nodes = $this->getNodesAsArray();
            foreach ($nodes as $nodeData) {
                $node = $this->nodeFactory->create(
                    [
                        'data' => $nodeData,
                        'idField' => 'id',
                        'tree' => $subject->getMenu()->getTree()
                    ]
                );
                $subject->getMenu()->addChild($node);
            }
        }
    }

    public function getNodesAsArray()
    {
        $baseUrl = $this->urlInterface->getBaseUrl();
        $nodes = [];

        switch ($baseUrl) {
            case "https://gelishmorgantaylor.co.uk/":
                $nodes[] = [
                    'name' => __('Education'),
                    'id' => 'education-site-link',
                    'url' => 'https://gelishmorgantaylor.education',
                    'has_active' => false,
                    'is_active' => $this->isActive('https://gelishmorgantaylor.education')
                ];
                break;
            case "https://entitybeauty.com/":
                $nodes[] = [
                    'name' => __('Blog'),
                    'id' => 'entity-blog-link',
                    'url' => 'https://entitybeauty.com/blog',
                    'has_active' => false,
                    'is_active' => $this->isActive('https://entitybeauty.com/blog')
                ];
                $nodes[] = [
                    'name' => __('Register LED Light'),
                    'id' => 'warranty-link',
                    'url' => 'https://entitybeauty.com/warrantyregistration',
                    'has_active' => false,
                    'is_active' => $this->isActive('https://entitybeauty.com/warrantyregistration')
                ];
                break;
            case "https://entitybeauty.co.uk/":
                $nodes[] = [
                    'name' => __('Blog'),
                    'id' => 'entity-blog-link',
                    'url' => 'https://entitybeauty.co.uk/blog',
                    'has_active' => false,
                    'is_active' => $this->isActive('https://entitybeauty.co.uk/blog')
                ];
                $nodes[] = [
                    'name' => __('Register LED Light'),
                    'id' => 'warranty-link',
                    'url' => 'https://entitybeauty.co.uk/warrantyregistration',
                    'has_active' => false,
                    'is_active' => $this->isActive('https://entitybeauty.co.uk/warrantyregistration')
                ];
                break;
        };

        return $nodes;
    }

    private function isActive(string $nodeUrl)
    {
        $currentUrl = $this->urlInterface->getCurrentUrl();
        return strpos($currentUrl, $nodeUrl) !== false;
    }
}

