<?php

namespace Pideph\Document;

/**
 * Pideph\Document\Output
 *
 * @author naitsirch <naitsirch@e.mail.de>
 */
class Output
{
    private $version;
    private $out;

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $vp = explode('.', $version);
        if (count($vp) != 2 || $vp[0] != 1 || $vp[1] < 0 || $vp[1] > 7) {
            throw new \InvalidArgumentException("The specified version $version is invalid for PDF documents.");
        }
        
        $this->version = $version;
        
        return $this;
    }

    public function add($content)
    {
        $this->out = $this->out . $content;

        return $this;
    }
}
