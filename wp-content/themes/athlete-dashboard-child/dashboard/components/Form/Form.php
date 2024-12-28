<?php

namespace AthleteDashboard\Dashboard\Components;

class Form {
    private $id;
    private $className;
    private $attributes;

    public function __construct(string $id, array $attributes = [], string $className = '') {
        $this->id = $id;
        $this->className = $className;
        $this->attributes = $attributes;
    }

    public function render(): string {
        $attributes = $this->buildAttributes();
        return sprintf(
            '<form id="%s" class="form %s" %s>%s</form>',
            esc_attr($this->id),
            esc_attr($this->className),
            $attributes,
            $this->getContent()
        );
    }

    private function buildAttributes(): string {
        $attributeStrings = [];
        foreach ($this->attributes as $key => $value) {
            if (is_bool($value)) {
                if ($value) {
                    $attributeStrings[] = esc_attr($key);
                }
            } else {
                $attributeStrings[] = sprintf('%s="%s"', esc_attr($key), esc_attr($value));
            }
        }
        return implode(' ', $attributeStrings);
    }

    protected function getContent(): string {
        return '';
    }

    public static function create(string $id, array $attributes = [], string $className = ''): self {
        return new static($id, $attributes, $className);
    }
} 