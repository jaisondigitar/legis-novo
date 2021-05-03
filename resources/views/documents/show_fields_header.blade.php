<section class="header">
    <div class="brasao">
        <img src="{{ url('uploads/company/'.$company->image) }}" alt="">
    </div>
    <div class="text">
        <span class="title">{{ $company->fullName }}</span><br>
        <span class="telefone">{{ $company->phone1 }} | {{ $company->email }}</span><br><br>
        <p class="cidade">{{ $company->getCity->name }} - {{ $company->getState->uf }}</p>
    </div>
</section>