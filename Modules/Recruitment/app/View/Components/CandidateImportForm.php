<?php

namespace Modules\Recruitment\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class CandidateImportForm extends Component
{
    /**
     * Create a new component instance.
     */
    public $placements;
    public $placementId;

    /**
     * Create a new component instance.
     */
    public function __construct($placements, $placementId)
    {
        $this->placements = $placements;
        $this->placementId = $placementId;
    }

    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('recruitment::college.bulk-import.import-form');
    }
}
