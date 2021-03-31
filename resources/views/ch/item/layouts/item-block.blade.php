<div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 mb-3">
    <div class="card">
        <a href="/ch/item/{{ $item->name }}">
            <img src="{{ asset($item->getCoverImage()) }}" class="card-img-top" alt="image">
        </a>
        <div class="card-body">
            <h5 class="card-title text-truncate">{{ $item->name }}</h5>
            <span style="color: brown;">
                @if($item->getPriceRange()['min'] == $item->getPriceRange()['max'])
                    RM{{ $item->getPriceRange()['min'] }}
                @else
                    RM{{ $item->getPriceRange()['min'] }} - RM{{ $item->getPriceRange()['max'] }}
                @endif
            </span>
            <div class="row">
                <div class="col text-left">
                    {{ $item->util->sold }} sold
                </div>
                <div class="col text-right">
                    <i class="icofont-eye"></i> {{ $item->util->view_count }}
                </div>
            </div>
        </div>
    </div>
</div>

