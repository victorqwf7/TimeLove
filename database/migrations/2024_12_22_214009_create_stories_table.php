<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('capsule_id');
            $table->string('media_type', 20); // foto, video, texto, etc.
            $table->string('media_path')->nullable(); // caminho do arquivo (fotos, vídeos)
            $table->text('content')->nullable(); // caso o story seja só texto
            $table->integer('duration')->default(5); // segundos de exibição
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->nullable();

            // Se tiver a tabela capsules criada, podemos criar a chave estrangeira
            $table->foreign('capsule_id')->references('id')->on('capsules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
