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
        $baseUrl = $this->urlInterface->getBaseUrl();

        switch ($baseUrl) {
            case "https://gelishmorgantaylor.co.uk/":
                $name = "";
                $id = "";
                $url = "";
                $path = "";
                break;
            case "https://entitybeauty.com/":
                $name = "";
                $id = "";
                $url = "";
                $path = "";
                break;
        };

        return [
            'name' => __($name),
            'id' => $id,
            'url' => $baseUrl . $path,
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
        }

        if (strpos($currentUrl, $activeUrls) !== false) {
            return true;
        }
        return false;
    }
}
