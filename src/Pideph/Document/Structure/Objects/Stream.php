<?php

namespace Pideph\Document\Structure\Objects;

use ArrayObject;

/**
 * Pideph\Document\Structure\Objects\Stream
 *
 * See Adobe PDF Reference, Edition 2008-7-1 (§7.3.8.2 Stream Objects)
 *
 * @author naitsirch
 */
class Stream extends TypedDictionary
{
    /**
     * The content of the stream.
     * @var string
     */
    private $content = '';

    /**
     * (Optional) The name of a filter that shall be applied in
     * processing the stream data found between the keywords
     * stream and endstream, or an array of zero, one or several
     * names. Multiple filters shall be specified in the order in which
     * they are to be applied.
     * @var Name|ArrayObject
     */
    private $filter;

    /**
     * (Optional) A parameter dictionary or an array of such
     * dictionaries, used by the filters specified by Filter. If there is
     * only one filter and that filter has parameters, DecodeParms
     * shall be set to the filter’s parameter dictionary unless all the
     * filter’s parameters have their default values, in which case the
     * DecodeParms entry may be omitted. If there are multiple
     * filters and any of the filters has parameters set to nondefault
     * values, DecodeParms shall be an array with one entry for
     * each filter: either the parameter dictionary for that filter, or the
     * null object if that filter has no parameters (or if all of its
     * parameters have their default values). If none of the filters
     * have parameters, or if all their parameters have default values,
     * the DecodeParms entry may be omitted.
     * @var Dictionary|ArrayObject
     */
    private $decodeParms;

    /**
     * (Optional; PDF 1.2) The file containing the stream data. If this
     * entry is present, the bytes between stream and endstream
     * shall be ignored. However, the Length entry should still specify
     * the number of those bytes (usually, there are no bytes and
     * Length is 0). The filters that are applied to the file data shall be
     * specified by FFilter and the filter parameters shall be specified
     * by FDecodeParms.
     * @var file specification
     */
    private $f;

    /**
     * (Optional; PDF 1.2) The name of a filter to be applied in
     * processing the data found in the stream’s external file, or an
     * array of zero, one or several such names. The same rules
     * apply as for Filter.
     * @var Name|ArrayObject
     */
    private $fFilter;

    /**
     * (Optional; PDF 1.2) A parameter dictionary, or an array of such
     * dictionaries, used by the filters specified by FFilter. The same
     * rules apply as for DecodeParms.
     * @var Dictionary|ArrayObject
     */
    private $fDecodeParms;

    /**
     * (Optional; PDF 1.5) A non-negative integer representing the
     * number of bytes in the decoded (defiltered) stream. It can be
     * used to determine, for example, whether enough disk space is
     * available to write a stream to a file.
     * This value shall be considered a hint only; for some stream
     * filters, it may not be possible to determine this value precisely.
     * @var int
     */
    private $dL;

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function addContent($content)
    {
        $this->content .= $content;
    }

    /**
     * Returns the number of bytes from the beginning of the line
     * following the keyword stream to the last byte just before the
     * keyword endstream. (There may be an additional EOL
     * marker, preceding endstream, that is not included in the count
     * and is not logically part of the stream data.) See 7.3.8.2,
     * "Stream Extent", for further discussion.
     * @return int
     */
    public function getLength()
    {
        return strlen($this->content);
    }

    public function getFilter()
    {
        return $this->filter;
    }

    public function setFilter($filter)
    {
        $this->filter = Name::by($filter);
    }

    public function getDecodeParms()
    {
        return $this->decodeParms;
    }

    public function setDecodeParms(Dictionary $decodeParms)
    {
        $this->decodeParms = $decodeParms;
    }

    public function getF()
    {
        return $this->f;
    }

    public function setF(file $f)
    {
        $this->f = $f;
    }

    public function getFFilter()
    {
        return $this->fFilter;
    }

    public function setFFilter(Name $fFilter)
    {
        $this->fFilter = $fFilter;
    }

    public function getFDecodeParms()
    {
        return $this->fDecodeParms;
    }

    public function setFDecodeParms(Dictionary $fDecodeParms)
    {
        $this->fDecodeParms = $fDecodeParms;
    }

    public function getDL()
    {
        return $this->dL;
    }

    public function setDL($dL)
    {
        $this->dL = $dL;
    }

    protected function getStaticDictionaryFields()
    {
        return array(
            'dL',
            'decodeParms',
            'f',
            'fDecodeParms',
            'fFilter',
            'filter',
            'length',
        );
    }
}
