<?php
    namespace Zorca;

    use Leafo\ScssPhp\Compiler;

    class Scss
    {

        private $importPath = [];
        private $scss = '';

        public function compile($scss) {
            $compiler = new Compiler();
            foreach ($this->importPath as $path) {
                $compiler->addImportPath($path);
            }
            return $compiler->compile($scss);
        }

        public function compileFile($in, $out) {
            $this->scss = '@charset "utf-8";';
            foreach ($in as $inItem) {
                $this->importPath($inItem);
            }

            $css = $this->compile($this->scss);
            $css = csscrush_string($css, ['formatter' => 'block']);
            if (!file_exists($out)) {
                if (!file_exists(dirname($out))) {
                    mkdir(dirname($out), 0775, true);
                }
            }
            return file_put_contents($out, $css);
        }

        private function importPath($scssFile) {
            $scss = '';
            $path = pathinfo($scssFile);
            if (file_exists($pathRelateImport = $scssFile) ||
                file_exists($pathRelateImport = (isset($path['extension']) ? $scssFile . '.scss' : '')) ||
                file_exists($pathRelateImport = dirname($scssFile) . '/_' . basename($scssFile) . (isset($path['extension']) ? $scssFile . '.scss' : ''))
            ) {
                $scss = file_get_contents($scssFile);
            }
            if (!empty($scss)) {
                $this->scss .= PHP_EOL . $scss;
                preg_match_all('%(//)?.*@import\s*"(.*)"%i', $scss, $result, PREG_PATTERN_ORDER);
                for ($i = 0; $i < count($result[0]); $i++) {
                    if (empty($result[1][$i])) {
                        $pathImport = dirname($scssFile) . DS . $result[2][$i];
                        if (!in_array(dirname($scssFile), $this->importPath)) {
                            $this->importPath[] = dirname($scssFile);
                        }
                        $this->importPath($pathImport);
                    }
                }
            }
        }
    }