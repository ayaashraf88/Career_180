<div>
    <textarea 
        wire:model.live="tweet" 
        class="border {{ strlen($tweet) > $maxLength ? 'border-red-500' : 'border-gray-300' }} p-2"
    ></textarea>

    <div class="{{ strlen($tweet) > $maxLength ? 'text-red-500' : 'text-gray-700' }}">
        <span>{{ strlen($tweet) }}</span> / {{ $maxLength }}
    </div>
</div>