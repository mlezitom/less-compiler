<?php

/**
 * LessCompiler
 *
 * @author Tomas Mleziva
 */
class LessCompiler {
	
	protected $srcPath;
	protected $targetPath;
	protected $filesMapping = [];
	
	public function run() {
		
		if(!$this->srcPath) {
			throw new \Nette\InvalidStateException("Please specify srcPath first.");
		}
		if(!$this->targetPath) {
			throw new \Nette\InvalidStateException("Please specify targetPath first.");
		}
		
		$lastLessEditTime = 0;
		foreach(\Nette\Utils\Finder::find("*.less")->from($this->getSrcPath()) as $file) {
			$lastLessEditTime = max($lastLessEditTime, $file->getMTime());
		}
		$lastCompileTime = 0;
		foreach(\Nette\Utils\Finder::find("*.css")->from($this->getTargetPath()) as $file) {
			$lastCompileTime = max($lastCompileTime, $file->getMTime());
		}
		$compiler = new \lessc();
		foreach($this->getfilesMapping() as $src => $target) {
			if(!is_file($this->targetPath . "/" . $target) || $lastLessEditTime > $lastCompileTime) {
				$compiler->compileFile($this->srcPath . "/" . $src, $this->targetPath . "/" . $target);
			}
		}
	}
	
	/* g/s */
	function getSrcPath() {
		return $this->srcPath;
	}

	function getTargetPath() {
		return $this->targetPath;
	}

	function getFilesMapping() {
		return $this->filesMapping;
	}

	function setSrcPath($srcPath) {
		$this->srcPath = $srcPath;
		return $this;
	}

	function setTargetPath($targetPath) {
		$this->targetPath = $targetPath;
		return $this;
	}

	function addTask($srcFile, $targetFile) {
		$this->filesMapping[$srcFile] = $targetFile;
		return $this;
	}
}