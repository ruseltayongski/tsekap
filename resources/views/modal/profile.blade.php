<div class="modal fade" role="dialog" id="dengvaxia">
    <div class="modal-dialog modal-md" role="document">
        <input type="hidden" name="currentID" id="currentID">
        <div class="modal-content">
            <div class="modal-body">
                <fieldset>
                    <legend><i class="fa fa-users"></i> Verify Dengvaxia</legend>
                    <div class="verify-dengvaxia">
                        <center>
                            <img src="{{ asset('resources/img/spin.gif') }}" width="100" />
                        </center>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="unmetNeed">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-female"></i> UNMET NEED
            </div>
            <div class="modal-body">
                <div class="alert alert-success btn-unmet" data-id="1" data-dismiss="modal" style="cursor: pointer;">
                    <p class="text-success">
                        <strong>Option 1</strong><br />
                        Women of Reproductive Age who wants to limit/space but no access to Family Planning Method.
                    </p>
                </div>
                <div class="alert alert-info btn-unmet" data-id="2" data-dismiss="modal" style="cursor: pointer;">
                    <p class="text-success">
                        <strong>Option 2</strong><br />
                        Couples and individuals who are fecund and sexually active and report not wanting any more children or wanting to delay the next pregnancy but are not using any Family Planning Method.
                    </p>
                </div>
                <div class="alert alert-warning btn-unmet" data-id="3" data-dismiss="modal" style="cursor: pointer;">
                    <p class="text-success">
                        <strong>Option 3</strong><br />
                        Currently using Family Planning Method but in inappropriate way thus leading to pregnancy.
                    </p>
                </div>
                <div class="alert alert-danger btn-unmet" data-id="4" data-dismiss="modal" style="cursor: pointer;">
                    <p class="text-success">
                        <strong>Option 4</strong><br />
                        Women of reproductive age not sexually active
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" role="dialog" id="waterLvl">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fa fa-glass"></i> SAFE WATER SUPPLY
            </div>
            <div class="modal-body">
                <div class="alert alert-success btn-water" data-id="1" data-dismiss="modal" style="cursor: pointer;">
                    <p class="text-success">
                        <strong>Level 1</strong><br />
                        Farthest user is not more than 250m from point source
                    </p>
                </div>
                <div class="alert alert-info btn-water" data-id="2" data-dismiss="modal" style="cursor: pointer;">
                    <p class="text-success">
                        <strong>Level 2</strong><br />
                        Farthest user is not more than 25m from communal faucet
                    </p>
                </div>
                <div class="alert alert-warning btn-water" data-id="3" data-dismiss="modal" style="cursor: pointer;">
                    <p class="text-success">
                        <strong>Level 3</strong><br />
                        It has service connection from system.
                    </p>
                </div>
                <div class="alert alert-success btn-water" data-id="4" data-dismiss="modal" style="cursor: pointer;">
                    <p class="text-success">
                        <strong>None of the above</strong><br />
                        User's connection is not defined in the above list.
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->