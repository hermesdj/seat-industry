<div class="modal fade" tabindex="-1" role="dialog" id="modalCreateProfile">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-orange">
                <h5 class="modal-title">
                    <i class="fas fa-pencil"></i>
                    {{ trans('seat-industry::profiles.modals.createProfile.title') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{!! trans('seat-industry::profiles.modals.createProfile.title') !!}</p>
                <form
                        action="{{ route("seat-industry.createProfile") }}"
                        method="POST"
                        class="form-horizontal"
                >
                    @csrf
                    <div class="form-group">
                        <label for="name">{{trans('seat-industry::profiles.fields.name')}}</label>
                        <input type="text" id="profit" class="form-control" name="name" minlength="3" maxlength="64"/>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="scope" id="scope1" value="personal" checked/>
                        <label class="form-check-label" for="scope1">
                            {{trans('seat-industry::profiles.scopes.personal')}}
                        </label>
                    </div>
                    <div class="form-check">
                        <input
                                class="form-check-input" type="radio" name="scope" id="scope1" value="corporation"
                                @cannot('seat-industry.manage_corporation_profile')
                                    disabled
                                @endcannot
                        />
                        <label class="form-check-label" for="scope1">
                            {{trans('seat-industry::profiles.scopes.corporation')}}
                        </label>
                    </div>
                    <div class="form-check">
                        <input
                                class="form-check-input" type="radio" name="scope" id="scope2" value="alliance"
                                @cannot('seat-industry.manage_alliance_profile')
                                    disabled
                                @endcannot
                        />
                        <label class="form-check-label" for="scope2">
                            {{trans('seat-industry::profiles.scopes.alliance')}}
                        </label>
                    </div>
                    <div class="form-check">
                        <input
                                class="form-check-input" type="radio" name="scope" id="scope3" value="public"
                                @cannot('seat-industry.manage_public_profile')
                                    disabled
                                @endcannot
                        />
                        <label class="form-check-label" for="scope3">
                            {{trans('seat-industry::profiles.scopes.public')}}
                        </label>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <button type="button" class="btn btn-light" data-dismiss="modal">
                            <i class="fas fa-times-circle"></i> {{ trans('web::seat.back') }}
                        </button>
                        <button
                                type="submit"
                                class="btn btn-success"
                        >
                            <i class="fas fa-check-circle"></i>&nbsp;
                            {{trans('seat-industry::profiles.btns.create')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>