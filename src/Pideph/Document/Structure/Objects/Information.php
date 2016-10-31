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

    /**
     * (Optional; PDF 1.1) The document's title.
     * 
     * @var string
     */
    private $title;

    /**
     * (Optional) The name of the person who created the document.
     * 
     * @var string
     */
    private $author;

    /**
     * (Optional; PDF 1.1) The subject of the document.
     * 
     * @var string
     */
    private $subject;

    /**
     * (Optional; PDF 1.1) Keywords associated with the document.
     *
     * @var string
     */
    private $keywords;

    /**
     * (Optional) If the document was converted to PDF from another format,
     * the name of the conforming product that created the original document
     * from which it was converted.
     *
     * @var string
     */
    private $creator;

    /**
     * (Optional) If the document was converted to PDF from another format,
     * the name of the conforming product that converted it to PDF.
     *
     * @var string
     */
    private $producer;

    /**
     * (Optional) The date and time the document was created, in human-
     * readable form (see 7.9.4, "Dates").
     *
     * @var \DateTime
     */
    private $creationDate;

    /**
     * (Required if PieceInfo is present in the document catalogue;
     * otherwise optional; PDF 1.1) The date and time the document was
     * most recently modified, in human-readable form (see 7.9.4, "Dates").
     *
     * @var \DateTime
     */
    private $modDate;

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
     * @var Name
     */
    private $trapped;

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
        return $this->title;
    }

    /**
     * See getter
     * 
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * (Optional) The name of the person who created the document.
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * See getter
     * 
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * (Optional; PDF 1.1) The subject of the document.
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * See getter
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * (Optional; PDF 1.1) Keywords associated with the document.
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * See getter
     * @param string $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
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
        return $this->creator;
    }

    /**
     * See getter
     * @param string $creator
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
    }

    /**
     * (Optional) If the document was converted to PDF from another format,
     * the name of the conforming product that converted it to PDF.
     *
     * @return string
     */
    public function getProducer()
    {
        return $this->producer;
    }

    /**
     * See getter
     *
     * @param string $producer
     */
    public function setProducer($producer)
    {
        $this->producer = $producer;
    }

    /**
     * (Optional) The date and time the document was created, in human-
     * readable form (see 7.9.4, "Dates").
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * See getter
     * @param \DateTime $date
     */
    public function setCreationDate(\DateTime $date)
    {
        $this->creationDate = $date;
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
        return $this->modDate;
    }

    /**
     * See getter
     * @param \DateTime $date
     */
    public function setModDate(\DateTime $date)
    {
        $this->modDate = $date;
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
        return $this->trapped;
    }

    /**
     * See getter
     * @param Name|string $trapped
     */
    public function setTrapped($trapped)
    {
        $this->trapped = Name::by($trapped);
    }

    public function isOnlyIndirectlyReferencable()
    {
        return true;
    }

    protected function getStaticDictionaryFields()
    {
        return array(
            'Author',
            'CreationDate',
            'Creator',
            'Keywords',
            'ModDate',
            'Producer',
            'Subject',
            'Title',
            'Trapped',
        );
    }
}
