<template>
            <div>
            <div class="row">
                <div class="col-2">
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Logistic Instruction</option>
                        <option value="1">Service Instruction</option>
                    </select>
                </div>
                <div class="col-8"></div>
                <div class="col-2 d-flex justify-content-end">
                    <div class="rounded-pill bg-info-subtle w-50 h-fit">
                        <p class="mx-auto my-0 text-center">Draft</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col"></div>
                <div class="col">
                    <label for="assigned-vendor">Assigned Vendor</label>
                    <input type="text" readonly required class="form-control bg-info-subtle" placeholder="Enter Vendor">
                </div>
                <div class="col">
                    <label for="attention-of">Attention Of</label>
                    <input id="attention-of" type="text" class="form-control" placeholder="Enter Attention Of" required>
                </div>
                <div class="col">
                    <label for="quotation-no">Quotation No.</label>
                    <input id="quotation-no" type="text" class="form-control" placeholder="Enter Quotation" required>
                </div>
                <div class="col">
                    <label for="invoice-to">Invoice to</label>
                    <select id="invoice-to" class="form-select" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="col border-left-dashed">
                    <label for="customer-contract">Customer Contract</label>
                    <select id="costomer-contract" class="form-select" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>                    
                </div>
            </div>
            <div class="row">
                <div class="col-2"></div>
                <div class="col-8">
                    <label for="vendor-address">Vendor Address</label>
                    <select id="vendor-address" class="form-select" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>                                        
                </div>
                <div class="col-2 border-left-dashed">
                    <label for="costomer-po-no">Customer PO No.</label>
                    <input id="customer-po-no" type="text" class="form-control" placeholder="Enter Customer PO">
                </div>
            </div>
        </div>
</template>