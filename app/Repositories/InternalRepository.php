<?php

namespace App\Repositories;

use App\Models\Internal;

use MongoDB\Exception\InvalidArgumentException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class InternalRepository
{
    protected $internal;

    public function __construct(Internal $internal)
    {
        $this->internal = $internal;
    }

    public function downloadAttachment(string $instructionId, string $fileName)
    {
        return Storage::download("/documents/instructions/" . substr($instructionId, 0, 12) . "/internal_attachments/" . $fileName, $fileName);
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
        $internal = $this->internal->where('instruction_id', substr($instructionId, 0, 12))->first();
        return $internal;
    }

    /**
     * untuk menyimpan data internal baru jika belum dibuat untuk instruksi yang sudah ada
     */
    public function saveNew(string $instructionId) : Object
    {
        $internal = new $this->internal;

        $internal->instruction_id = $instructionId;
        $internal->internal_attachment = [];
        $internal->internal_notes = [];
        $internal->activity_log = [];

        $internal->save();
        return $internal->fresh();
    }

    /**
     * untuk menyimpan daftar attachment internal dalam sebuah instruksi
     */
    public function saveAttachment(array $data, string $action) : Object 
    {
        $internal = $this->getById($data['instruction_id']);
        $attachmentList = $internal->internal_attachment;

        if ($action == 'store') {
            $data['attachment']->storeAs("/documents/instructions/" . substr($data['instruction_id'], 0, 12) . "/internal_attachments", $data['file_name']);
            $attachment['attachment'] = $data['file_name'];
            $attachment['posted_by'] = $data['posted_by'];
            $attachment['date_added'] = (string)Carbon::now('+7:00');
            $attachmentList[] = $attachment;
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
    
            if ($action == 'store') {
                $note['posted_by'] = $data['posted_by'];
                $note['date_posted'] = (string)Carbon::now('+7:00');
                $noteList[] = $note;
            } else if ($action == 'update') {
                if ($noteList[$data['index']]['posted_by'] == $data['posted_by']) {
                    $note['posted_by'] = $noteList[$data['index']]['posted_by'];
                    $note['date_posted'] = $noteList[$data['index']]['date_posted'];
                    $note['date_modified'] = (string)Carbon::now('+7:00');
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
        $internal = $this->internal->where('instruction_id', substr($data['instruction_id'], 0, 12))->first();
        $newLogList = $internal->activity_log;
        $newLog = array_intersect_key($data, array_flip(['action', 'by', 'date']));
        $newLogList[] = $newLog;
        $internal->activity_log = $newLogList;
        $internal->save();
    }

    /**
     * untuk menghapus data internal berdasarkan id
     */
    public function delete(string $instructionId) : void
    {
        $this->internal->where('instruction_id', substr($instructionId, 0, 12))->delete();
    }
}