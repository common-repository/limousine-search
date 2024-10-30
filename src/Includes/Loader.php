<?php

namespace LimousineSearch\Includes;

class Loader
{
	protected array $actions = [];
	protected array $filters = [];

	public function addAction(string $hook, object $component, string $callback, int $priority = 10, int $acceptedArgs = 1): void
    {
		$this->actions = $this->add($this->actions, $hook, $component, $callback, $priority, $acceptedArgs);
	}

	public function addFilter(string $hook, object $component, string $callback, int $priority = 10, int $acceptedArgs = 1): void
    {
		$this->filters = $this->add($this->filters, $hook, $component, $callback, $priority, $acceptedArgs);
	}

	private function add(array $hooks, string $hook, object $component, string $callback, int $priority, int $acceptedArgs): array
    {
        $hooks[] = [
            'hook' => $hook,
            'component' => $component,
            'callback' => $callback,
            'priority' => $priority,
            'accepted_args' => $acceptedArgs,
        ];

		return $hooks;
	}

	public function run(): void
    {
		foreach ($this->filters as $hook) {
			add_filter($hook['hook'], [$hook['component'], $hook['callback']], $hook['priority'], $hook['accepted_args']);
		}

		foreach ($this->actions as $hook) {
			add_action($hook['hook'], [$hook['component'], $hook['callback']], $hook['priority'], $hook['accepted_args']);
		}
	}
}
