<?php

namespace Nailalliance\AddCategoryLink\Plugin\Block;

use Magento\Framework\Data\Tree\NodeFactory;
use Magento\Store\Model\StoreManagerInterface;

class Catnav
{
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
        // $storeId = $this->storeManager->getStore()->getId(); // Alternatively, use store ID
        $allowedStores = ['entitybeautyview', 'gelishmorgantaylorview', 'default'];

        if (in_array($storeCode, $allowedStores)) {
            $node = $this->nodeFactory->create(
                [
                    'data' => $this->getNodeAsArray(),
                    'idField' => 'id',
                    'tree' => $subject->getMenu()->getTree()
                ]
            );
            $subject->getMenu()->addChild($node);
        }
    }

    public function getNodeAsArray()
    {
        $baseUrl = $this->urlInterface->getBaseUrl();

        switch ($baseUrl) {
            case "https://gelishmorgantaylor.co.uk/":
                $name = "Education";
                $id = "education-site-link";
                $path = 'https://gelishmorgantaylor.education';
                break;
            case "https://entitybeauty.com/":
                $name = "Blog";
                $id = "entity-blog-link";
                $path = 'https://entitybeauty.com/blog';
                break;
            case "https://entitybeauty.co.uk/":
                $name = "Blog";
                $id = "entity-blog-link";
                $path = 'https://entitybeauty.co.uk/blog';
                break;
        };

        return [
            'name' => __($name),
            'id' => $id,
            'url' => $path,
            'has_active' => false,
            'is_active' => $this->isActive($baseUrl)
        ];
    }


    private function isActive(string $storeUrl)
    {
        $activeUrls = "";
        $currentUrl = $this->urlInterface->getCurrentUrl();

        switch ($storeUrl) {
            case "https://gelishmorgantaylor.co.uk/":
                $activeUrls = 'https://gelishmorgantaylor.education/';
                break;
            case "https://entitybeauty.com/":
                $activeUrls = 'https://entitybeauty.com/blog';
                break;
            default:
                break;
        }

        if (strpos($currentUrl, $activeUrls) !== false) {
            return true;
        }
        return false;
    }
}
