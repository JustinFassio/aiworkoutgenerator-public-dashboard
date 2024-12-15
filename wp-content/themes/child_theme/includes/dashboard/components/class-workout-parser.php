<?php
/**
 * Workout Parser Component
 * 
 * Handles parsing natural language workout content into structured data
 */

class Athlete_Dashboard_Workout_Parser {
    /**
     * Parse workout content into structured data
     */
    public function parse_workout_content($content) {
        // Create a DOM document
        $dom = new DOMDocument();
        @$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
        $xpath = new DOMXPath($dom);
        
        // Initialize structure
        $workout = array(
            'sections' => array(),
            'meta' => array(
                'title' => '',
                'description' => '',
                'duration' => '',
                'difficulty' => '',
                'equipment' => array()
            )
        );
        
        // Extract metadata from first paragraph or header
        $metaNode = $xpath->query('//h1|//h2|//p')->item(0);
        if ($metaNode) {
            $this->parse_metadata($metaNode->textContent, $workout['meta']);
        }
        
        // Find potential section markers (headers, strong text, etc)
        $nodes = $xpath->query('//h2|//h3|//strong|//p');
        $current_section = null;
        
        foreach ($nodes as $node) {
            $text = trim($node->textContent);
            
            // Check if this is a new section
            $section_type = $this->identify_section_type($text);
            if ($section_type) {
                if ($current_section) {
                    $workout['sections'][] = $current_section;
                }
                $current_section = array(
                    'type' => $section_type,
                    'title' => $text,
                    'exercises' => array(),
                    'rawHtml' => ''
                );
                continue;
            }
            
            // If we haven't started a section yet, create a default one
            if (!$current_section) {
                $current_section = array(
                    'type' => 'main',
                    'title' => 'Workout',
                    'exercises' => array(),
                    'rawHtml' => ''
                );
            }
            
            // Try to parse exercise information
            $exercise = $this->parse_exercise($text);
            if ($exercise) {
                $current_section['exercises'][] = $exercise;
            } else {
                // Store unparseable content
                $current_section['rawHtml'] .= $dom->saveHTML($node);
            }
        }
        
        // Add the last section
        if ($current_section) {
            $workout['sections'][] = $current_section;
        }
        
        return $workout;
    }
    
    /**
     * Identify section type from text
     */
    private function identify_section_type($text) {
        $text = strtolower($text);
        
        if (strpos($text, 'warm up') !== false || strpos($text, 'warmup') !== false) {
            return 'warmup';
        }
        
        if (strpos($text, 'cool down') !== false || strpos($text, 'cooldown') !== false) {
            return 'cooldown';
        }
        
        if (strpos($text, 'workout') !== false || 
            strpos($text, 'exercise') !== false || 
            strpos($text, 'circuit') !== false) {
            return 'main';
        }
        
        return null;
    }
    
    /**
     * Parse exercise information from text
     */
    private function parse_exercise($text) {
        // Common exercise patterns
        $patterns = array(
            // 3x10 pattern
            '/(\d+)\s*x\s*(\d+)\s+(.*)/i',
            // Exercise name followed by sets and reps
            '/(.*?)\s*[-:]\s*(\d+)\s+sets?\s*,?\s*(\d+)\s+reps?/i',
            // Simple exercise name with reps
            '/(.*?)\s+for\s+(\d+)\s+reps?/i'
        );
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                return array(
                    'name' => trim(end($matches)),
                    'sets' => isset($matches[1]) ? intval($matches[1]) : 1,
                    'reps' => isset($matches[2]) ? intval($matches[2]) : 0,
                    'description' => $text
                );
            }
        }
        
        return null;
    }
    
    /**
     * Parse metadata from text
     */
    private function parse_metadata($text, &$meta) {
        // Duration pattern
        if (preg_match('/(\d+)\s*(min|minute)s?/i', $text, $matches)) {
            $meta['duration'] = intval($matches[1]);
        }
        
        // Difficulty patterns
        $difficulties = array('easy', 'moderate', 'intermediate', 'hard', 'advanced');
        foreach ($difficulties as $difficulty) {
            if (stripos($text, $difficulty) !== false) {
                $meta['difficulty'] = $difficulty;
                break;
            }
        }
        
        // Equipment patterns
        $equipment = array('dumbbells', 'barbell', 'kettlebell', 'resistance bands', 'bodyweight');
        foreach ($equipment as $item) {
            if (stripos($text, $item) !== false) {
                $meta['equipment'][] = $item;
            }
        }
    }
} 