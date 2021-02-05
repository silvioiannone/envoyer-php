<?php

namespace SilvioIannone\EnvoyerPhp\Resources;

use Illuminate\Support\Collection;
use SilvioIannone\EnvoyerPhp\Resource;

/**
 * Projects resource.
 */
class Projects extends Resource
{
    /**
     * Get the projects.
     */
    public function all(): Collection
    {
        return collect($this->sendGet()->get('projects'));
    }
    
    /**
     * Deploy a project.
     */
    public function deploy(int $id): void
    {
        $this->sendPost($id . '/deployments');
    }
    
    /**
     * Get a project's deployments.
     */
    public function deployments(int $id): Collection
    {
        return collect($this->sendGet($id . '/deployments')->get('deployments'));
    }
    
    /**
     * Get a deploymnet.
     */
    public function deployment(int $projectId, int $id): Collection
    {
        return collect($this->sendGet($projectId . '/deployments/' . $id)->get('deployment'));
    }
}
