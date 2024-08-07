<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('job_applications', 'annees_experience')) {
                $table->integer('annees_experience')->nullable();
            }
            if (!Schema::hasColumn('job_applications', 'statut_employee')) {
                $table->string('statut_employee')->nullable();
            }
            if (!Schema::hasColumn('job_applications', 'salaire_actuel')) {
                $table->decimal('salaire_actuel', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('job_applications', 'salaire_souhaite')) {
                $table->decimal('salaire_souhaite', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('job_applications', 'tj_actual')) {
                $table->decimal('tj_actual', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('job_applications', 'tj_souhaite')) {
                $table->decimal('tj_souhaite', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('job_applications', 'disponibilite')) {
                $table->string('disponibilite')->nullable();
            }
            if (!Schema::hasColumn('job_applications', 'preavis')) {
                $table->string('preavis')->nullable();
            }
            if (!Schema::hasColumn('job_applications', 'niveau_etudes')) {
                $table->string('niveau_etudes')->nullable();
            }
            if (!Schema::hasColumn('job_applications', 'statut')) {
                $table->string('statut')->nullable();
            } 
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_applications', function (Blueprint $table) {
            if (Schema::hasColumn('job_applications', 'annees_experience')) {
                $table->dropColumn('annees_experience');
            }
            if (Schema::hasColumn('job_applications', 'statut_employee')) {
                $table->dropColumn('statut_employee');
            }
            if (Schema::hasColumn('job_applications', 'salaire_actuel')) {
                $table->dropColumn('salaire_actuel');
            }
            if (Schema::hasColumn('job_applications', 'salaire_souhaite')) {
                $table->dropColumn('salaire_souhaite');
            }
            if (Schema::hasColumn('job_applications', 'tj_actual')) {
                $table->dropColumn('tj_actual');
            }
            if (Schema::hasColumn('job_applications', 'tj_souhaite')) {
                $table->dropColumn('tj_souhaite');
            }
            if (Schema::hasColumn('job_applications', 'disponibilite')) {
                $table->dropColumn('disponibilite');
            }
            if (Schema::hasColumn('job_applications', 'preavis')) {
                $table->dropColumn('preavis');
            }
            if (Schema::hasColumn('job_applications', 'niveau_etudes')) {
                $table->dropColumn('niveau_etudes');
            }
            if (Schema::hasColumn('job_applications', 'statut')) {
                $table->dropColumn('statut');
            }
        });
    }
};
