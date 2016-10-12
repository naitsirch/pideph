# PDF Reference

*Source: [Adobe PDF Reference](http://wwwimages.adobe.com/www.adobe.com/content/dam/Adobe/en/devnet/pdf/pdfs/PDF32000_2008.pdf)*

## Objects

### Boolean Objects
* Boolean objects represent the logical values of true and false
* keywords: `true` and `false`.

### Numeric Objects
* two types of numeric objects: **integer** and **real**
* integers:
  * `123`    `43445`    `+17`    `-98`    `0`
* example for real values:
  * `34.5`    `-3.62`    `+123.6`    `4.`    `-.002`    `0.0`

### String Objects
* A string object shall consist of a series of zero or more bytes

#### Literal Strings
* enclosed in parentheses
* Any characters may appear in string except unbalanced parentheses
* Examples:
  * `(This is a string)`
  * `(Strings may contain newlines  
and such.)`
  * `(Strings may contain balanced parentheses ( ) and  
special characters ( * ! & } ^ % and so on).)`
  * `(The following is an empty string.)`
  * `( )`
  * `(It has zero (0) length.)`

#### Hexadecimal Strings
* Strings may also be written in hexadecimal form
* written as a sequence of hexadecimal digits (0–9 and either A–F or a–f)
* encoded as  ASCII  characters  and  enclosed  within  angle  brackets `<` and `>`
* Examples:
  * `<4E6F762073686D6F7A206B6120706F702E>`
  * `<901FA3>`  
is a 3-byte string consisting of the characters whose hexadecimal codes are 90, 1F, and A3, but  
`<901FA>`  
is a 3-byte string containing the characters whose hexadecimal codes are 90, 1F, and A0.

### Name Objects
*(since PDF-1.2)*
* Name object is an unique symbol defined by a sequence of any characters (8-bit values) except null (character code 0)
* Starts with a slash `/` (but the slash is not a part of the name)
* Valid Examples:
  * `/Name1`
  * `/ASomewhatLongerName`
  * `/A;Name_With-Various***Characters?`
  * `/1.2`
  * `/$$`
  * `/@pattern`
  * `/.notdef`
  * `/lime#20Green`
  * `/paired#28#29parentheses`
  * `/The_Key_of_F#23_Minor`
  * `/A#42`

### Array Objects
* An array object is a one-dimensional collection of objects
* may include other arrays
* enclosed by `[` and `]`
* array entries are devided by spaces
* Example:
  * `[549 3.14 false (Ralph) /SomeName]`

### Dictionary Objects
* is an associative table containing pairs of objects
* first element of each entry is the key and the second element is the value
* the key shall be a name, the value may be any kind of object, including another dictionary
* A dictionary shall be written as a sequence of key-value pairs enclosed in `<<` and `>>`
* Example:


        << /Type /Example 
          /Subtype /DictionaryExample 
          /Version 0.01 
          /IntegerItem 12 
          /StringItem (a string) 
          /Subdictionary << /Item1 0.4 
                            /Item2 true 
                            /LastItem  (not!) 
                            /VeryLastItem  (OK) 
                         >> 
        >>


### Stream Objects


## File Structure

### File Header

* The first line of a PDF file is the header line
* consisting of `%PDF-` followed by version number


        %PDF–1.0
        %PDF–1.1
        %PDF–1.2
        %PDF–1.3
        %PDF–1.4
        %PDF–1.5
        %PDF–1.6
        %PDF–1.7


### File Body

* The body of a PDF file shall consist of a sequence of indirect objects 
  representing the contents of a document.
* Beginning with PDF 1.5, the body can also contain object streams


### Cross-Reference Table

* cross-reference table contains information for random access to indirect 
objects within the file so that the entire file need not be read to locate any particular object
* specifying the byte offset of that object within the body of the file
* each cross-reference section shall begin with a line containing the keyword xref.
* Following this line shall be one or more cross-reference subsections

#### Example 1

* The following line introduces a subsection containing five objects numbered consecutively from 28 to 32.
  * `28 5`

* each entry shall be exactly 20 bytes long, including the end-of-line marker
* There are two kinds of cross-reference entries: one for objects that are in use 
and another for objects that have been deleted and therefore are free
* both have similar basic formats
* distinguished by the keyword n (for an in-use entry) or f (for a free entry)
* format of an in-use entry:
  * `nnnnnnnnnn ggggg n eol`
* nnnnnnnnnn shall be a 10-digit byte offset in the decoded stream
* ggggg shall be a 5-digit generation number
* n shall be a keyword identifying this as an in-use entry
* eol shall be a 2-character end-of-line sequence

* The byte offset in the decoded stream shall be a 10-digit number
* padded with leading zeros if necessary,
* giving the number of bytes from the beginning of the file to the beginning of the object

* The generation number shall be a 5-digit number
* also padded with leading zeros if necessary
* Following the generation number shall be a single SPACE
* then the keyword n
* and a 2-character end-of-line sequence
* consisting of one of the following: SP CR, SP LF, or CR LF
* Thus, the overall length of the entry shall always be exactly 20 bytes.

#### Example 2

* The following shows a cross-reference section consisting of a single subsection with six entries:
* four that are in use (objects number 1, 2, 4, and 5) 
* and two that are free (objects number 0 and 3)
* Object number 3 has been deleted, and the next object created with that object
number is given a generation number of 7


        xref
        0 6
        0000000003 65535 f
        0000000017 00000 n
        0000000081 00000 n
        0000000000 00007 f
        0000000331 00000 n
        0000000409 00000 n


#### Example 3

* The following shows a cross-reference section with four subsections
* containing a total of five entries.
* The first subsection contains one entry, for object number 0, which is free.
* The second subsection contains one entry, for object number 3, which is in use.
* The third subsection contains two entries, for objects number 23 and 24, both of which are in use
* Object number 23 has been reused, as can be seen from the fact that it has a generation number of 2
* The fourth subsection contains one entry, for object number 30, which is in use.


        xref
        0 1
        0000000000 65535 f
        3 1
        0000025325 00000 n
        23 2
        0000025518 00002 n
        0000025635 00000 n
        30 1
        0000025777 00000 n




(bis Seite 40)
