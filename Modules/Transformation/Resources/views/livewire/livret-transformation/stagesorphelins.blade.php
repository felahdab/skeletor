 <div class="accordion">
    <div class="accordion-item">
        <div class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStages">
                <h3>Stages attribués mais non liés à une fonction</h3>
            </button>
        </div>
        <div id="collapseStages" class="accordion-collapse collapse">
            <div  class="accordion-body">
                <table class='table'>
                    @foreach($user->getTransformationManager()->stages_orphelins() as $stage)
                        <tr class='bg-secondary bg-opacity-25 div-table-contrat-compagnonnage'>
                            <th colspan='2'>
                                @if($stage->stage_lienurl != NULL)
                                    <a href="{{$stage->stage_lienurl}}" target="_blank"><x-bootstrap-icon iconname='link-45deg.svg'/></a>
                                @endif
                                {{$stage->stage_libcourt }}
                            </th>
                        </tr>
                        <tr class='ligneTache'>
                            <td>
                                @if ($datvalid=$user->getTransformationManager()->dateDeValidationDuStage($stage) )
                                    @if($datvalid> date('Y-m-d'))
                                        <button class='btn' type='button' disabled style="background-color:orangered;">
                                        INSCRIT {{ $user->getTransformationManager()->dateDeValidationDuStage($stage) }}
                                        </button>
                                    @else
                                        <button class='btn btn-success' type='button' disabled>
                                        VALIDE {{ $user->getTransformationManager()->dateDeValidationDuStage($stage) }}
                                        </button>
                                    @endif
                                @else
                                    <button class='btn btn-warning' type='button' disabled>
                                    NON VALIDE A CE JOUR
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach <!-- foreach stage -->
                </table>
            </div>
        </div>
    </div>
</div>