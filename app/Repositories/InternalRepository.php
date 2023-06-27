<?php

namespace App\Repositories;

use App\Models\Internal;

use MongoDB\Exception\InvalidArgumentException;

class InternalRepository
{
    protected $internal;

    public function __construct(Internal $internal)
    {
        $this->internal = $internal;
    }

    /** 
     * untuk mengambil semua list internal
     */
    public function getAll() : Object
    {
        $internals = $this->internal->get();
        return $internals;
    }

    /**
     * untuk mengambil data internal berdasarkan id instruksi
     */
    public function getById(string $instructionId) : ?Object
    {
        $internal = $this->internal->where('instruction_id', $instructionId)->first();
        return $internal;
    }

    /**
     * untuk menyimpan daftar attachment internal dalam sebuah instruksi
     */
    public function saveAttachment(array $data, string $action) : Object 
    {
        $internal = $this->getById($data['instruction_id']);
        $attachmentList = $internal->internal_attachment;

        if ($action == 'store') {
            $attachmentList[] = $data['attachment'];
            $internal->date_added = now('+7:00');
        } else if ($action == 'delete') {
            array_splice($attachmentList, $data['index'], 1);
        }
        
        $internal->internal_attachment = $attachmentList;

        $internal->save();
        return $internal->fresh();
    }

    /**
     * untuk menyimpan daftar internal notes sebuah instruksi
     */
    public function saveNotes(array $data, string $action) : Object 
    {
        $internal = $this->getById($data['instruction_id']);
        $noteList = $internal->internal_notes;

        if ($action == 'delete') {
            if ($noteList[$data['index']]['posted_by'] == $data['posted_by']) {
                array_splice($noteList, $data['index'], 1);
            } else {
                throw new InvalidArgumentException('User ini tidak berhak menghapus note user lain');
            }
        } else {
            $note['note'] = $data['note'];
            $note['posted_by'] = $data['posted_by'];
            $note['date_posted'] = now('+7:00');
    
            if ($action == 'store') {
                $noteList[] = $note;
            } else if ($action == 'update') {
                if ($noteList[$data['index']]['posted_by'] == $data['posted_by']) {
                    $noteList[$data['index']] = $note;
                } else {
                    throw new InvalidArgumentException('User ini tidak berhak menyunting note user lain');
                }
            }
        }
        
        $internal->internal_notes = $noteList;
        $internal->save();
        return $internal->fresh();
    }

    /**
     * untuk menyimpan log instruksi
     */
    public function storeLog(array $data) : void
    {
        $internal = $this->internal->where('instruction_id', $data['instruction_id'])->first();
        $newLogList = $internal->activity_log;
        $newLog = array_intersect_key($data, array_flip(['action', 'by', 'date']));
        $newLogList[] = $newLog;
        $internal->activity_log = $newLogList;
        $internal->save();
    }
}