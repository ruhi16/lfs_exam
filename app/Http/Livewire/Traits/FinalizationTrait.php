<?php

namespace App\Http\Livewire\Traits;

trait FinalizationTrait
{
    public $showFinalizeModal = false;
    public $finalizingId = null;
    public $isDataFinalized = false;

    protected function checkGlobalFinalizationStatus($modelClass)
    {
        $this->isDataFinalized = $modelClass::where('is_finalized', true)->exists();
    }

    public function confirmFinalize($id)
    {
        $this->finalizingId = $id;
        $this->showFinalizeModal = true;
    }

    public function finalizeData($modelClass, $entityName = 'item')
    {
        if ($this->finalizingId) {
            $item = $modelClass::findOrFail($this->finalizingId);
            $item->update(['is_finalized' => true]);
            
            $this->checkGlobalFinalizationStatus($modelClass);
            session()->flash('message', ucfirst($entityName) . ' finalized successfully! No further changes allowed.');
        }
        
        $this->showFinalizeModal = false;
        $this->finalizingId = null;
    }

    public function unfinalizeData($id, $modelClass, $entityName = 'item')
    {
        $item = $modelClass::findOrFail($id);
        $item->update(['is_finalized' => false]);
        
        $this->checkGlobalFinalizationStatus($modelClass);
        session()->flash('message', ucfirst($entityName) . ' unfinalized successfully! Changes are now allowed.');
    }

    public function cancelFinalize()
    {
        $this->showFinalizeModal = false;
        $this->finalizingId = null;
    }

    protected function preventActionIfFinalized($action = 'modify data')
    {
        if ($this->isDataFinalized) {
            session()->flash('error', "Cannot {$action} - it has been finalized.");
            return true;
        }
        return false;
    }
}