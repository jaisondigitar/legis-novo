<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddColunmsAdvicesAttributesInLawProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laws_projects', function (Blueprint $table) {
            $table->integer('advice_situation_id');
            $table->integer('advice_publication_id');
            $table->date('advice_date')->default('0000-00-00 00:00:00');
            $table->date('first_discussion')->default('0000-00-00 00:00:00');
            $table->date('second_discussion')->default('0000-00-00 00:00:00');
            $table->date('third_discussion')->default('0000-00-00 00:00:00');
            $table->date('single_discussion')->default('0000-00-00 00:00:00');
            $table->date('special_urgency')->default('0000-00-00 00:00:00');
            $table->date('approved')->default('0000-00-00 00:00:00');
            $table->date('sanctioned')->default('0000-00-00 00:00:00');
            $table->date('Promulgated')->default('0000-00-00 00:00:00');
            $table->date('Rejected')->default('0000-00-00 00:00:00');
            $table->date('Vetoed')->default('0000-00-00 00:00:00');
            $table->date('Filed')->default('0000-00-00 00:00:00');
            $table->date('sustained')->default('0000-00-00 00:00:00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laws_projects', function (Blueprint $table) {
            $table->dropColumn('advice_situation_id');
            $table->dropColumn('advice_publication_id');
            $table->dropColumn('advice_date');
            $table->dropColumn('first_discussion');
            $table->dropColumn('second_discussion');
            $table->dropColumn('third_discussion');
            $table->dropColumn('single_discussion');
            $table->dropColumn('special_urgency');
            $table->dropColumn('approved');
            $table->dropColumn('sanctioned');
            $table->dropColumn('Promulgated');
            $table->dropColumn('Rejected');
            $table->dropColumn('Vetoed');
            $table->dropColumn('Filed');
            $table->dropColumn('sustained');
        });
    }
}
