<?php

namespace Gsx\Globalshopex\Plugin;

use Magento\Framework\App\Request\CsrfValidator;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ActionInterface;

class CsrfValidatorSkip
{
    /**
     * Plugin around for validate method.
     *
     * @param String $subject
     * @param \Closure $proceed
     * @param RequestInterface $request
     * @param ActionInterface $action
     */
    public function aroundValidate($subject, \Closure $proceed, $request, $action)
    {
        $referer = $request->getServer('HTTP_REFERER');

        $path = $request->getRequestUri();
        if ($path == '/globalshopex/gsx/index') {
            return;
        }
        $proceed($request, $action);
    }
}
