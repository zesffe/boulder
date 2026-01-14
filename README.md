# boulder

**boulder** is a PHP class for outputting `@font-face` definitions.

For example, a useful subset of PlexMono might be these seven weight-style combinations:

1. _IBMPlexMono-Bold.otf_
1. _IBMPlexMono-Italic.otf_
1. _IBMPlexMono-Light.otf_
1. _IBMPlexMono-LightItalic.otf_
1. _IBMPlexMono-Medium.otf_
1. _IBMPlexMono-MediumItalic.otf_
1. _IBMPlexMono-Regular.otf_

which can be passed to boulder:

```PHP
require 'boulder.php';

$css = new boulder();

$css->add([
	'family' => 'IBMPlexMono',
	'path' => '../fonts',
	'format' => 'opentype',
	'styles' => [
		'normal',
		'italic',
	],
	'weights' => [
		'light' => 300,
		'regular' => 400,
		'medium' => 500,
		'bold' => 700,
	],
]);

echo $css->export();
```

to result in eight `@font-face` combinations in CSS:

```CSS
/* IBMPlexMono: total 8 */

@font-face {
	font-family: 'IBMPlexMono';
	src: url('../fonts/IBMPlexMono-Light.otf') format('opentype');
	font-weight: 300;
	font-style: normal;
}

@font-face {
	font-family: 'IBMPlexMono';
	src: url('../fonts/IBMPlexMono-LightItalic.otf') format('opentype');
	font-weight: 300;
	font-style: italic;
}

@font-face {
	font-family: 'IBMPlexMono';
	src: url('../fonts/IBMPlexMono-Regular.otf') format('opentype');
	font-weight: 400;
	font-style: normal;
}

@font-face {
	font-family: 'IBMPlexMono';
	src: url('../fonts/IBMPlexMono-Italic.otf') format('opentype');
	font-weight: 400;
	font-style: italic;
}

@font-face {
	font-family: 'IBMPlexMono';
	src: url('../fonts/IBMPlexMono-Medium.otf') format('opentype');
	font-weight: 500;
	font-style: normal;
}

@font-face {
	font-family: 'IBMPlexMono';
	src: url('../fonts/IBMPlexMono-MediumItalic.otf') format('opentype');
	font-weight: 500;
	font-style: italic;
}

@font-face {
	font-family: 'IBMPlexMono';
	src: url('../fonts/IBMPlexMono-Bold.otf') format('opentype');
	font-weight: 700;
	font-style: normal;
}

@font-face {
	font-family: 'IBMPlexMono';
	src: url('../fonts/IBMPlexMono-BoldItalic.otf') format('opentype');
	font-weight: 700;
	font-style: italic;
}

/* /IBMPlexMono */
```

##### When rules for nonexistent fonts are generated

In this example, the class outputs eight rules, but only seven reference an existent font file; `IBMPlexMono-BoldItalic` is the one exception.

In other words, note that `BoldItalic` does not actually exist in the PlexMono family; a rule for `BoldItalic` is generated despite that `BoldItalic` is not part of the family. (The closest to a bold italic for PlexMono is `SemiboldItalic`.)

Until the class accepts a parameter for such exceptions, nonsense rules like this should just be deleted from the exported CSS.
