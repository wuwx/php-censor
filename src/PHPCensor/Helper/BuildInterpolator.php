<?php

namespace PHPCensor\Helper;

use PHPCensor\Model\Build as BaseBuild;

/**
 * The BuildInterpolator class replaces variables in a string with build-specific information.
 * 
 * @package PHPCensor\Helper
 */
class BuildInterpolator
{
    /**
     * An array of key => value pairs that will be used for
     * interpolation and environment variables
     * @var mixed[]
     * @see setupInterpolationVars()
     */
    protected $interpolation_vars = [];

    /**
     * Sets the variables that will be used for interpolation.
     * 
     * @param BaseBuild $build
     * @param string $buildPath
     * @param string $url
     */
    public function setupInterpolationVars(BaseBuild $build, $buildPath, $url)
    {
        $this->interpolation_vars = [];
        $this->interpolation_vars['%PHPCI%'] = 1;
        $this->interpolation_vars['%COMMIT%'] = $build->getCommitId();
        $this->interpolation_vars['%SHORT_COMMIT%'] = substr($build->getCommitId(), 0, 7);
        $this->interpolation_vars['%COMMIT_EMAIL%'] = $build->getCommitterEmail();
        $this->interpolation_vars['%COMMIT_MESSAGE%'] = $build->getCommitMessage();
        $this->interpolation_vars['%COMMIT_URI%'] = $build->getCommitLink();
        $this->interpolation_vars['%BRANCH%'] = $build->getBranch();
        $this->interpolation_vars['%BRANCH_URI%'] = $build->getBranchLink();
        $this->interpolation_vars['%ENVIRONMENT%'] = $build->getEnvironment();
        $this->interpolation_vars['%PROJECT%'] = $build->getProjectId();
        $this->interpolation_vars['%BUILD%'] = $build->getId();
        $this->interpolation_vars['%PROJECT_TITLE%'] = $build->getProjectTitle();
        $this->interpolation_vars['%PROJECT_URI%'] = $url . "project/view/" . $build->getProjectId();
        $this->interpolation_vars['%BUILD_PATH%'] = $buildPath;
        $this->interpolation_vars['%BUILD_URI%'] = $url . "build/view/" . $build->getId();
        $this->interpolation_vars['%PHPCI_COMMIT%'] = $this->interpolation_vars['%COMMIT%'];
        $this->interpolation_vars['%PHPCI_SHORT_COMMIT%'] = $this->interpolation_vars['%SHORT_COMMIT%'];
        $this->interpolation_vars['%PHPCI_COMMIT_MESSAGE%'] = $this->interpolation_vars['%COMMIT_MESSAGE%'];
        $this->interpolation_vars['%PHPCI_COMMIT_EMAIL%'] = $this->interpolation_vars['%COMMIT_EMAIL%'];
        $this->interpolation_vars['%PHPCI_COMMIT_URI%'] = $this->interpolation_vars['%COMMIT_URI%'];
        $this->interpolation_vars['%PHPCI_PROJECT%'] = $this->interpolation_vars['%PROJECT%'];
        $this->interpolation_vars['%PHPCI_BUILD%'] = $this->interpolation_vars['%BUILD%'];
        $this->interpolation_vars['%PHPCI_PROJECT_TITLE%'] = $this->interpolation_vars['%PROJECT_TITLE%'];
        $this->interpolation_vars['%PHPCI_PROJECT_URI%'] = $this->interpolation_vars['%PROJECT_URI%'];
        $this->interpolation_vars['%PHPCI_BUILD_PATH%'] = $this->interpolation_vars['%BUILD_PATH%'];
        $this->interpolation_vars['%PHPCI_BUILD_URI%'] = $this->interpolation_vars['%BUILD_URI%'];

        putenv('PHPCI=1');
        putenv('PHPCI_COMMIT=' . $this->interpolation_vars['%COMMIT%']);
        putenv('PHPCI_SHORT_COMMIT=' . $this->interpolation_vars['%SHORT_COMMIT%']);
        putenv('PHPCI_COMMIT_MESSAGE=' . $this->interpolation_vars['%COMMIT_MESSAGE%']);
        putenv('PHPCI_COMMIT_EMAIL=' . $this->interpolation_vars['%COMMIT_EMAIL%']);
        putenv('PHPCI_COMMIT_URI=' . $this->interpolation_vars['%COMMIT_URI%']);
        putenv('PHPCI_PROJECT=' . $this->interpolation_vars['%PROJECT%']);
        putenv('PHPCI_BUILD=' . $this->interpolation_vars['%BUILD%']);
        putenv('PHPCI_PROJECT_TITLE=' . $this->interpolation_vars['%PROJECT_TITLE%']);
        putenv('PHPCI_BUILD_PATH=' . $this->interpolation_vars['%BUILD_PATH%']);
        putenv('PHPCI_BUILD_URI=' . $this->interpolation_vars['%BUILD_URI%']);
        putenv('PHPCI_ENVIRONMENT=' . $this->interpolation_vars['%ENVIRONMENT%']);
    }

    /**
     * Replace every occurrence of the interpolation vars in the given string
     * Example: "This is build %PHPCI_BUILD%" => "This is build 182"
     * @param string $input
     * @return string
     */
    public function interpolate($input)
    {
        $keys = array_keys($this->interpolation_vars);
        $values = array_values($this->interpolation_vars);
        return str_replace($keys, $values, $input);
    }
}
