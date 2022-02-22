<?php

use App\Enums\VoteTypes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultiDocsVotingTable extends Migration
{
    public function up()
    {
        Schema::create('multi_docs_voting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('multi_voting_id')->references('id')
                ->on('multi_voting');
            $table->unsignedInteger('assemblymen_id')->references('id')
                ->on('assemblymen');
            $table->enum('vote', VoteTypes::$types);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('multi_docs_voting');
    }
}
