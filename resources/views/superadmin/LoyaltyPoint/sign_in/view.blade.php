                    <div class="modal-header">
                        <h5 class="modal-title" id="BlogLongTitle">Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <div class="modal-body bg-white px-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="points">Points<span style="color:red;">*</span></label>
                                        <input type="text" name="points" value="{{$data->points}}" class="form-control" id="points" required placeholder="Points">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status<span style="color:red;">*</span></label>
                                        <select name="status" class="form-control" disabled id="status">
                                            <option value="">--Select--</option>
                                            <option value="true" @if($data->status == true) selected @endif >Yes</option>
                                            <option value="false" @if($data->status == false) selected @endif >No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </div>