<a href="{{ url('/en/item/' . $item->id) }}" class="no-anchor-style">
    <div class="card shadow">

        {{-- Image --}}
        @if(!empty($item->images->toArray()))
            <a href="{{ url('/en/item/' . $item->id) }}">
                <img src="{{ $item->getCoverImage() }}" class="card-img-top" alt="image"
                     loading="lazy">
            </a>
        @endif
        {{-- Image --}}

        <div class="card-body">

            {{-- Title --}}
            <div class="h5 card-title text-truncate">
                {{ $item->name_en }}
            </div>
            {{-- Title --}}

            {{-- Price --}}
            <span class="price-text-normal">
                                    @if($item->getPriceRange()['min'] == $item->getPriceRange()['max'])
                    RM{{ $item->getPriceRange()['min'] }}
                @else
                    RM{{ $item->getPriceRange()['min'] }} -
                    RM{{ $item->getPriceRange()['max'] }}
                @endif
                                </span>
            {{-- Price --}}

            {{-- Wholesale Badge --}}
            @if(!empty($item->discounts->toArray()))
                <span class="badge rounded-pill bg-info">Wholesale</span>
            @endif
            {{-- Wholesale Badge --}}

            {{-- Stock & Total View --}}
            <div class="d-flex justify-content-between">
                <div>
                    <i class="icofont icofont-box"></i> {{ $item->getTotalStock() }}
                </div>
                <div>
                    <i class="icofont icofont-eye"></i> {{ $item->util->view_count }}
                </div>
            </div>
            {{-- Stock & Total View --}}
        </div>
    </div>
</a>
