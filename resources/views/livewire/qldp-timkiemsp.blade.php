<div class="col-12 col-md-12 col-lg-12">
<div class="item-hoso">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="form-group row" style="margin-bottom: 0px">
                <label for="noisinh" class="col-sm-12 col-form-label" style="padding-top: 0px; padding-bottom: 0px;font-weight: normal;">Điều tra:</label>
                <div class="col-sm-12">
                    <select wire:model="idchuyennganh" class=""  id="xnnh_nganh" style="width: 100%;height:28px;border:1px solid #ced4da;border-radius:.25rem">
                            <option value="-1">Chọn chuyên ngành</option>
                            <option value="1000">Chọn chuyêsdfsdfsn ngành</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

        @foreach ( $trungtuyen as $row )
            <div class="item-thisinh">
                <div class="item-header">
                    <div class="item-row1">
                        <div class="maphieu">
                            <span></span>
                            <strong>{{$row->hoten}}</strong>
                        </div>
                        <div class="maphieu">
                            <span>CMND:</span>
                            <strong>{{$row->cccd}}</strong>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

