<?php
use Illuminate\Console\Command;
use DPRMC\FileMunger\Engines\GS360JournalEntryToSentryFile;

class MungGS360JournalEntryToSentryFile extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dprmc:mung-gs360-journal-to-sentry';

    protected $engine;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Mung and FTP the GS 360 Journal Entry file to the Sentry system.";


    public function __construct(GS360JournalEntryToSentryFile $engine) {
        parent::__construct();
        $this->engine = $engine;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $this->line("Starting " . __CLASS__);

        $source = './source.csv';
        $destination = './munged.csv';

        $this->engine->mungAndSaveFile($source,
                                       $destination);
        $this->line("Finished " . __CLASS__);
    }
}