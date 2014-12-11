Compiles LESS files to CSS. Invalidates files automatically according to the file last change timestamp.

usage: 

$compiler = new \LessCompiler();
$compiler->setSrcPath($this->context->parameters['wwwDir'] . "/less");
$compiler->setTargetPath($this->context->parameters['wwwDir'] . "/css");
$compiler->addTask("main.less", "main.min.css");
$compiler->run();