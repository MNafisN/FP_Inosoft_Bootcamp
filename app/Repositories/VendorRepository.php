<?php

namespace App\Repositories;

use App\Models\Vendor;

class VendorRepository
{
    protected $vendor;

    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    /** 
     * untuk mengambil semua list vendor
     */
    public function getAll() : Object
    {
        $vendors = $this->vendor->select('vendor_name', 'vendor_address', 'vendor_invoice_provider')->get();
        return $vendors;
    }

    /**
     * untuk mengambil data vendor berdasarkan id
     */
    public function getById(string $vendorId) : ?Object
    {
        $vendor = $this->vendor->where('vendor_id', $vendorId)->first();
        return $vendor;
    }

    /**
     * untuk menambah data vendor address atau vendor invoice provider baru
     */
    public function save(array $data) : bool
    {
        $vendor = $this->vendor->where('vendor_name', $data['assigned_vendor'])->first();
        if (!$vendor) { return false; }

        if (in_array($data['vendor_address'], $vendor->toArray()['vendor_address']) == false) { 
            $newAddressList = $vendor->vendor_address;
            $newAddressList[] = $data['vendor_address'];
            $vendor->vendor_address = $newAddressList;
        }

        if (in_array($data['invoice_to'], $vendor->toArray()['vendor_invoice_provider']) == false) { 
            $newInvoiceTo = $vendor->vendor_invoice_provider;
            $newInvoiceTo[] = $data['invoice_to'];
            $vendor->vendor_invoice_provider = $newInvoiceTo;
        }

        $vendor->save();
        return true;
    }
}