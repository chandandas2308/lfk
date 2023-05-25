<!-- Modal -->
<div class="modal fade" id="viewOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content p-2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="viewPurchaseOrderForm">
                <div class="modal-body bg-white px-3">
                    <!-- invoice body start here -->

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="vendorNameOrder">Purchase Requisition No.</label>
                            <input type="text" name="" id="purchaseQuotationNumView" placeholder="Purchase Requisition No." class="form-control" disabled />
                        </div>
                        <!-- <div class="col-md-2 form-control text-center border-0 fw-bold text-dark">
                            <label for="vendorNameOrder"></label>
                            <h6>OR</h6>
                        </div> -->
                        <div class="col-md-6">
                            <label for="refOrderNumView">Purchase Order</label>
                            <input type="text" class="form-control text-dark" name="refOrderNum" id="refOrderNumView" placeholder="Purchase Order" disabled>
                        </div>
                    </div>

                    <!-- row 1 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="vendorNameOrderView">Vendor</label>
                            <input type="text" name="" id="vendorNameOrderView" class="form-control" disabled />
                        </div>
                        <div class="col-md-6">
                            <label for="receiptDateOrderView">Receipt Date</label>
                            <input type="date" name="" id="receiptDateOrderView" value="<?= date('Y-m-d') ?>" class="form-control" placeholder="Receipt Date" disabled />
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="vendorReferenceOrderView">Vendor Reference</label>
                            <input type="text" name="" id="vendorReferenceOrderView" class="form-control" placeholder="Vendor Reference" disabled />
                        </div>
                        <div class="col-md-6">
                            <label for="billingStatusView">Billing Status</label>
                            <select name="billingStatus" id="billingStatusView" class="form-control" disabled>
                                <option value="">Select Billing Status</option>
                                <option value="paid">Paid</option>
                                <option value="unpaid">Unpaid</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                    </div>

                    <!-- row 3 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input type="checkbox" class="mt-4" name="" value="confirm" id="askForConfirmPurchaseOrderView1"  onclick="return false" /> <label for="askForConfirmOrder" class="mt-4 text-primary">Ask for Confirmation</label>
                        </div>
                        <div class="col-md-6">
                            <!-- <input type="checkbox" name="" id="taxIncludeOrderView" disabled /> <label for="taxIncludeOrderEdit" class="text-primary">Tax inclusive</label> -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <label for="taxInclude" class="text-primary form-control"><input type="checkbox" name="taxInclude" id="taxIncludeOrderView"  onclick="return false"> Tax inclusive</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="gstValue" value="7" id="gstValueOrderView" min="1" placeholder="GST (In %)" disabled />
                                            <div class="input-group-append">
                                                <button class="btn btn-sm btn-facebook" type="button">
                                                    %
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- row 5 -->
                    <div class="form-group row">
                        <div class="col">
                            <fieldset class="border border-secondary p-2">
                                <legend class="float-none w-auto p-2">Order Details</legend>
                                <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                    <table class="table text-center border" id="productsTableOrderView" style="width: 100%; border-collapse: collapse;">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Product Name</th>
                                                <th>Category</th>
                                                <th>Variant</th>
                                                <th>Description</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Gross Amount</th>
                                                <th>Net Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="productTableBodyOrderView"></tbody>
                                    </table>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <a id="purchaseOrder_download_btn" class="btn btn-secondary my-2">Download</a>
                            <input type="text" name="" id="notesOrderView1" class="form-control" placeholder="Add an Internal Note" disabled />
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            <div class="row mx-auto my-1">
                                <div class="col-md-5 my-auto">Sub Total</div>
                                <div class="col-md-7 my-auto">
                                    <input type="number" name="" id="untaxtedAmountOrderView" class="form-control " placeholder="Sub Total" disabled />
                                </div>
                            </div>
                            <div class="row mx-auto my-1">
                                <div class="col-md-5 my-auto">GST</div>
                                <div class="col-md-7 my-auto">
                                    <input type="number" name="" id="gstOrderView" class="form-control" placeholder="GST" disabled />
                                </div>
                            </div>
                            <hr />
                            <div class="row mx-auto my-1">
                                <div class="col-md-5 my-auto">Grand Total</div>
                                <div class="col-md-7 my-auto">
                                    <input type="number" id="quotationTotalOrderView" name="" class="form-control" name="totalBill" placeholder="Grand Total" disabled>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- end here -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>



