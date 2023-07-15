<?php

namespace App\Repositories;

use App\Models\Attachment;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class AttachmentRepository
{
    protected $attachment;

    public function __construct(Attachment $attachment)
    {
        $this->attachment = $attachment;
    }

    public function download(string $fileName)
    {
        $attachment = $this->getByName($fileName);
        return Storage::download("/documents/" . $attachment->file_name, $attachment->file_name);
    }

    /** 
     * untuk mengambil semua list attachment
     */
    public function getAll() : Object
    {
        $attachments = $this->attachment->get();
        return $attachments;
    }

    /**
     * untuk mengambil data attachment berdasarkan id instruksi
     */
    // public function getById(string $instructionId) : ?Object
    // {
    //     $attachment = $this->attachment->where('instruction_id', substr($instructionId, 0, 12))->first();
    //     return $attachment;
    // }

    /**
     * untuk mengambil data attachment berdasarkan nama file attachment
     */
    public function getByName(string $name) : ?Object
    {
        $attachment = $this->attachment->where('file_name', 'LIKE', '%'.$name.'%')->first();
        return $attachment;
    }

    /**
     * untuk menyimpan data attachment baru jika belum dibuat untuk instruksi yang sudah ada
     */
    public function saveNew(array $data) : Object
    {
        $attachment = new $this->attachment;

        // $attachment->instruction_id = $instructionId;
        $data['attachment']->storeAs("/documents/", $data['file_name']);
        $attachment->file_name = $data['file_name'];
        $attachment->posted_by = $data['posted_by'];
        $attachment->created_at = (string)Carbon::now('+7:00')->toDateTimeString();

        $attachment->save();
        return $attachment->fresh();
    }

    /**
     * untuk menyimpan daftar attachment dalam sebuah instruksi
     */
    // public function saveAttachment(array $data, string $action) : Object 
    // {
    //     $attachment = $this->getById($data['instruction_id']);
    //     if (!$attachment) {
    //         $attachment = $this->saveNew($data['instruction_id']);
    //     }
    //     $attachmentList = $attachment->internal_attachment;

    //     if ($action == 'store') {
    //         $data['attachment']->storeAs("/documents/instructions/" . substr($data['instruction_id'], 0, 12) . "/internal_attachments", $data['file_name']);
    //         $attachment['attachment'] = $data['file_name'];
    //         $attachment['posted_by'] = $data['posted_by'];
    //         $attachment['date_added'] = (string)Carbon::now('+7:00');
    //         $attachmentList[] = $attachment;
    //     } else if ($action == 'delete') {
    //         array_splice($attachmentList, $data['index'], 1);
    //     }
        
    //     $attachment->internal_attachment = $attachmentList;

    //     $attachment->save();
    //     return $attachment->fresh();
    // }

    /**
     * untuk menghapus attachment berdasarkan nama
     */
    public function delete(string $name) : void
    {
        $attachment = $this->getByName($name);
        Storage::disk('public')->delete(("/documents/" . $name));
        $attachment->delete();
    }
}