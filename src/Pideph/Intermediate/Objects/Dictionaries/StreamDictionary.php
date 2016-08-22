<?php

namespace Pideph\Intermediate\Objects\Dictionaries;

/**
 * Pideph\Intermediate\Objects\Dictionaries\StreamDictionary
 *
 * @author naitsirch
 */
class StreamDictionary extends Dictionary
{
    /**
     * (Required) The number of bytes from the beginning of the line
     * following the keyword stream to the last byte just before the
     * keyword endstream. (There may be an additional EOL
     * marker, preceding endstream, that is not included in the count
     * and is not logically part of the stream data.)
     *
     * Value: integer
     */
    const KEY_LENGTH = 'Length';

    /**
     * (Optional) The name of a filter that shall be applied in
     * processing the stream data found between the keywords
     * stream and endstream, or an array of zero, one or several
     * names. Multiple filters shall be specified in the order in which
     * they are to be applied.
     *
     * Value: name or array
     */
    const KEY_FILTER = 'Filter';

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
     *
     * Value: dictionary or array
     */
    const KEY_DECODE_PARMS = 'DecodeParms';

    /**
     * (Optional; PDF 1.2) The file containing the stream data. If this
     * entry is present, the bytes between stream and endstream
     * shall be ignored. However, the Length entry should still specify
     * the number of those bytes (usually, there are no bytes and
     * Length is 0). The filters that are applied to the file data shall be
     * specified by FFilter and the filter parameters shall be specified
     * by FDecodeParms.
     *
     * Value: file specification
     */
    const KEY_F = 'F';

    /**
     * (Optional; PDF 1.2) The name of a filter to be applied in
     * processing the data found in the stream’s external file, or an
     * array of zero, one or several such names. The same rules
     * apply as for Filter.
     *
     * Value: name or array
     */
    const KEY_FFILTER = 'FFilter';

    /**
     * (Optional; PDF 1.2) A parameter dictionary, or an array of such
     * dictionaries, used by the filters specified by FFilter. The same
     * rules apply as for DecodeParms.
     *
     * Value: dictionary or array
     */
    const KEY_FDECODE_PARMS = 'fDecodeParms';

    /**
     * (Optional; PDF 1.5) A non-negative integer representing the
     * number of bytes in the decoded (defiltered) stream. It can be
     * used to determine, for example, whether enough disk space is
     * available to write a stream to a file.
     * This value shall be considered a hint only; for some stream
     * filters, it may not be possible to determine this value precisely.
     *
     * Value: integer
     */
    const KEY_DL = 'DL';

    public function __construct(array $data)
    {
        $resolver = $this->getOptionsResolver();
        $resolver->setRequired(array(
            self::KEY_LENGTH,
        ));
        $resolver->setOptional(array(
            self::KEY_DECODE_PARMS,
            self::KEY_DL,
            self::KEY_F,
            self::KEY_FDECODE_PARMS,
            self::KEY_FFILTER,
            self::KEY_FILTER,
        ));

        parent::__construct($resolver->resolve($data));
    }
}
