<?php

namespace Pideph\Document\Structure\Objects;

/**
 * Pideph\Document\Structure\Objects\Information
 *
 * See Adobe PDF Reference, Edition 2008-7-1 (§14.3.3 Document Information Dictionary)
 *
 * @author naitsirch
 */
class Information extends TypedDictionary
{
    const TRAPPED_TRUE = 'True';
    const TRAPPED_FALSE = 'False';
    const TRAPPED_UNKNOWN = 'Unknown';

    public function __construct()
    {
        if (isset($_SERVER['USER'])) {
            $this->setAuthor($_SERVER['USER']);
        }
        $this->setCreator('pideph');
        $this->setProducer('pideph');
        $this->setCreationDate(new \DateTime());
        $this->setTrapped(self::TRAPPED_UNKNOWN);
    }

    /**
     * (Optional; PDF 1.1) The document's title.
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->offsetGet('Title');
    }

    /**
     * See getter
     * 
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->offsetSet('Title', $title);
    }

    /**
     * (Optional) The name of the person who created the document.
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->offsetGet('Author');
    }

    /**
     * See getter
     * 
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->offsetSet('Author', $author);
    }

    /**
     * (Optional; PDF 1.1) The subject of the document.
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->offsetGet('Subject');
    }

    /**
     * See getter
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->offsetSet('Subject', $subject);
    }

    /**
     * (Optional; PDF 1.1) Keywords associated with the document.
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->offsetGet('Keywords');
    }

    /**
     * See getter
     * @param string $keywords
     */
    public function setKeywords($keywords)
    {
        $this->offsetSet('Keywords', $keywords);
    }

    /**
     * (Optional) If the document was converted to PDF from another format,
     * the name of the conforming product that created the original document
     * from which it was converted.
     *
     * @return string
     */
    public function getCreator()
    {
        return $this->offsetGet('Creator');
    }

    /**
     * See getter
     * @param string $creator
     */
    public function setCreator($creator)
    {
        $this->offsetSet('Creator', $creator);
    }

    /**
     * (Optional) If the document was converted to PDF from another format,
     * the name of the conforming product that converted it to PDF.
     *
     * @return string
     */
    public function getProducer()
    {
        return $this->offsetGet('Producer');
    }

    /**
     * See getter
     *
     * @param string $creator
     */
    public function setProducer($creator)
    {
        $this->offsetSet('Producer', $creator);
    }

    /**
     * (Optional) The date and time the document was created, in human-
     * readable form (see 7.9.4, "Dates").
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->offsetGet('CreationDate');
    }

    /**
     * See getter
     * @param \DateTime $date
     */
    public function setCreationDate(\DateTime $date)
    {
        $this->offsetSet('CreationDate', $date);
    }

    /**
     * (Required if PieceInfo is present in the document catalogue;
     * otherwise optional; PDF 1.1) The date and time the document was
     * most recently modified, in human-readable form (see 7.9.4, "Dates").
     * 
     * @return \DateTime
     */
    public function getModDate()
    {
        return $this->offsetGet('ModDate');
    }

    /**
     * See getter
     * @param \DateTime $date
     */
    public function setModDate(\DateTime $date)
    {
        $this->offsetSet('ModDate', $date);
    }

    /**
     * (Optional; PDF 1.3) A name object indicating whether the document
     * has been modified to include trapping information (see 14.11.6,
     * "Trapping Support"):
     *     True     The document has been fully trapped; no further trapping
     *              shall be needed. This shall be the name True, not the
     *              boolean value true.
     *     False    The document has not yet been trapped. This shall be the
     *              name False, not the boolean value false.
     *     Unknown  Either it is unknown whether the document has been
     *             trapped or it has been partly but not yet fully trapped; some
     *             additional trapping may still be needed.
     * Default value: Unknown.
     * 
     * @return Name
     */
    public function getTrapped()
    {
        return $this->offsetGet('Trapped');
    }

    /**
     * See getter
     * @param Name|string $trapped
     */
    public function setTrapped($trapped)
    {
        $this->offsetSet('Trapped', Name::by($trapped));
    }

    protected function getStaticDictionaryFields()
    {
        return array();
    }
}
