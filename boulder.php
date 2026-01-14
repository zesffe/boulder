<?php

class boulder {

	public $fonts = [];


	public function add(array $font): void {

		$this->fonts[$font['family']] = $font;
	}


	public function export(): string {

		$css = [];

		foreach ($this->fonts as $family => $font) {

			$count = count($font['styles']) * count($font['weights']);

			$css[] = "\n/* $family: total $count */\n";

			$css[] = $this->generate($font);

			$css[] = "\n/* /$family */\n";
		}

		return implode("\n", $css);
	}


	private function generate(array $font): string {

		$res = [];

		extract($font);

		$extension = $this->getExtension($format);

		foreach ($weights as $weightName => $weightInt) {

			$weightName = ucfirst($weightName);

			foreach ($styles as $style) {

				$styleName = strtolower($style) === 'italic' ? 'Italic' : '';

				if ("{$weightName}{$styleName}" == 'RegularItalic') $weightName = '';

				$filename = "{$path}/{$family}-{$weightName}{$styleName}.{$extension}";

				$rules = [
					"font-family: '{$family}';",
					"src: url('{$filename}') format('{$format}');",
					"font-weight: {$weightInt};",
					"font-style: {$style};",
				];

				$res[] = "@font-face {\n\t" . implode("\n\t", $rules) . "\n}";
			}
		}

		return implode("\n\n", $res);
	}


	private function getExtension(string $format): string {

		$exts = [
			'opentype' => 'otf',
			'truetype' => 'ttf',
			'woff' => 'woff',
			'woff2' => 'woff2',
		];

		if (! isset($exts[$format])) throw new InvalidArgumentException("{$format} is not recognized!");
		
		return $exts[$format];
	}

}

