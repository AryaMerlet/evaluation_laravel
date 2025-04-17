<?php

use App\Classes\Commun\ExtendBlueprint;
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
    public function up(): void
    {
        $schema = DB::getSchemaBuilder();
        $schema->blueprintResolver(function ($table, $callback) {
            return new ExtendBlueprint($table, $callback);
        });

        $schema->create('salles', function (ExtendBlueprint $table) {
            $table->id();

            $table->string('name')->unique();
            $table->integer('capacity');
            $table->float('surface');

            $table->whoAndWhen();
        });
        Bouncer::allow('salarie')->to('salle-retrieve');
        Bouncer::allow('admin')->to('salle-create');
        Bouncer::allow('admin')->to('salle-update');
        Bouncer::allow('admin')->to('salle-delete');
        Bouncer::allow('admin')->to('salle-retrieve');
        Bouncer::Refresh();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('salles');
        Schema::enableForeignKeyConstraints();
    }
};
