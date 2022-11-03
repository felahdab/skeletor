<div class="accordion">
    <div class="accordion-item">
        <div class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStages">
                <h5>Stages</h5>
            </button>
        </div>
        <div id="collapseStages" class="accordion-collapse collapse">
            <div  class="accordion-body">
                <table class='table'>
                    @foreach($fonction->stages()->get() as $stage)

                    <tr class=' bg-secondary bg-opacity-25 div-table-contrat-compagnonnage'>
                        <th colspan='2'>{{$stage->stage_libcourt }}</th>
                    </tr>
                    <tr class='ligneTache'>
                        <td>
                            @if ($user->aValideLeStage($stage))
                                <button class='btn btn-success' type='button' disabled>
                                VALIDE {{ $user->stages()->find($stage)->pivot->date_validation }}
                                </button>
                            @else
                                <button class='btn btn-warning' type='button' disabled>
                                NON VALIDE A CE JOUR
                                </button>
                                @if (false)
                                    <input type='checkbox' 
                                    id='stageid[{{$stage->id}}]' 
                                    name='stageid[{{$stage->id}}]' 
                                    value='stageid[{{$stage->id}}]'>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach <!-- foreach stage -->
                </table>
            </div>
        </div>
    </div>
</div>