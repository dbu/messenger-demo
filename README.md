# Symfony Messenger Demonstration

This application is a simple messenger demonstration. Saving a text for either Wintermute or Neuromancer is made slow on
purpose. Instead of Saving directly in the controller (as done in `/naive`), the `/wintermute` and `/neuromancer`
endpoints use Symfony messenger to not block the web process.

You can open `/stats` in a web browser to see what is going on. That page refreshes itself automatically.

To generate a bunch of messages to see the queues in action, there is a command `app:generate-messages`.

In order to ingest the data, you need to run the message workers. Run this Symfony command and choose the queue you want
to consume from:

    bin/console messenger:consume -vv

To run workers in parallel, I installed GNU `parallel` into the docker container. Specify the queue name to the `yes`
command and the number of parallel workers you want with the `-j` flag to `parallel`:

    yes wintermute | parallel -j 10 --line-buffer bin/console messenger:consume

You can specify any flags to `messenger:consume` as usual, e.g. `-vv` to see what messages are processed, or the
rejuvenation controls.

This will just keep running forever, and parallel should lead to having exactly the specified number of workers running.
It will start a new worker each time a worker exits for whatever reason.

In a real system, you would want to run this process with a supervisor to restart `yes` and `parallel` itself, should
they crash. Or use an actual dynamic task scheduler that adjusts workers depending on on queue size.
