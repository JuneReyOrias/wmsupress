<div wire:loading>
    <div style="z-index:100;display:flex; justify-content:center; align-items:center;
        background-color:black; position:fixed; top:0px; left:0px; z-indez:9999;
        width:100%; height:100%; opacity:.70;">
        <div class="la-ball-8bits">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>
<style>
    .la-ball-8bits,
    .la-ball-8bits > div {
        position: relative;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
                box-sizing: border-box;
    }
    .la-ball-8bits {
        display: block;
        font-size: 0;
        color: #fff;
    }
    .la-ball-8bits.la-dark {
        color: #333;
    }
    .la-ball-8bits > div {
        display: inline-block;
        float: none;
        background-color: currentColor;
        border: 0 solid currentColor;
    }
    .la-ball-8bits {
        width: 12px;
        height: 12px;
    }
    .la-ball-8bits > div {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 4px;
        height: 4px;
        border-radius: 0;
        opacity: 0;
        -webkit-transform: translate(100%, 100%);
        -moz-transform: translate(100%, 100%);
            -ms-transform: translate(100%, 100%);
            -o-transform: translate(100%, 100%);
                transform: translate(100%, 100%);
        -webkit-animation: ball-8bits 1s 0s ease infinite;
        -moz-animation: ball-8bits 1s 0s ease infinite;
            -o-animation: ball-8bits 1s 0s ease infinite;
                animation: ball-8bits 1s 0s ease infinite;
    }
    .la-ball-8bits > div:nth-child(1) {
        -webkit-animation-delay: -.9375s;
        -moz-animation-delay: -.9375s;
            -o-animation-delay: -.9375s;
                animation-delay: -.9375s;
    }
    .la-ball-8bits > div:nth-child(2) {
        -webkit-animation-delay: -.875s;
        -moz-animation-delay: -.875s;
            -o-animation-delay: -.875s;
                animation-delay: -.875s;
    }
    .la-ball-8bits > div:nth-child(3) {
        -webkit-animation-delay: -.8125s;
        -moz-animation-delay: -.8125s;
            -o-animation-delay: -.8125s;
                animation-delay: -.8125s;
    }
    .la-ball-8bits > div:nth-child(4) {
        -webkit-animation-delay: -.75s;
        -moz-animation-delay: -.75s;
            -o-animation-delay: -.75s;
                animation-delay: -.75s;
    }
    .la-ball-8bits > div:nth-child(5) {
        -webkit-animation-delay: -.6875s;
        -moz-animation-delay: -.6875s;
            -o-animation-delay: -.6875s;
                animation-delay: -.6875s;
    }
    .la-ball-8bits > div:nth-child(6) {
        -webkit-animation-delay: -.625s;
        -moz-animation-delay: -.625s;
            -o-animation-delay: -.625s;
                animation-delay: -.625s;
    }
    .la-ball-8bits > div:nth-child(7) {
        -webkit-animation-delay: -.5625s;
        -moz-animation-delay: -.5625s;
            -o-animation-delay: -.5625s;
                animation-delay: -.5625s;
    }
    .la-ball-8bits > div:nth-child(8) {
        -webkit-animation-delay: -.5s;
        -moz-animation-delay: -.5s;
            -o-animation-delay: -.5s;
                animation-delay: -.5s;
    }
    .la-ball-8bits > div:nth-child(9) {
        -webkit-animation-delay: -.4375s;
        -moz-animation-delay: -.4375s;
            -o-animation-delay: -.4375s;
                animation-delay: -.4375s;
    }
    .la-ball-8bits > div:nth-child(10) {
        -webkit-animation-delay: -.375s;
        -moz-animation-delay: -.375s;
            -o-animation-delay: -.375s;
                animation-delay: -.375s;
    }
    .la-ball-8bits > div:nth-child(11) {
        -webkit-animation-delay: -.3125s;
        -moz-animation-delay: -.3125s;
            -o-animation-delay: -.3125s;
                animation-delay: -.3125s;
    }
    .la-ball-8bits > div:nth-child(12) {
        -webkit-animation-delay: -.25s;
        -moz-animation-delay: -.25s;
            -o-animation-delay: -.25s;
                animation-delay: -.25s;
    }
    .la-ball-8bits > div:nth-child(13) {
        -webkit-animation-delay: -.1875s;
        -moz-animation-delay: -.1875s;
            -o-animation-delay: -.1875s;
                animation-delay: -.1875s;
    }
    .la-ball-8bits > div:nth-child(14) {
        -webkit-animation-delay: -.125s;
        -moz-animation-delay: -.125s;
            -o-animation-delay: -.125s;
                animation-delay: -.125s;
    }
    .la-ball-8bits > div:nth-child(15) {
        -webkit-animation-delay: -.0625s;
        -moz-animation-delay: -.0625s;
            -o-animation-delay: -.0625s;
                animation-delay: -.0625s;
    }
    .la-ball-8bits > div:nth-child(16) {
        -webkit-animation-delay: 0s;
        -moz-animation-delay: 0s;
            -o-animation-delay: 0s;
                animation-delay: 0s;
    }
    .la-ball-8bits > div:nth-child(1) {
        top: -100%;
        left: 0;
    }
    .la-ball-8bits > div:nth-child(2) {
        top: -100%;
        left: 33.3333333333%;
    }
    .la-ball-8bits > div:nth-child(3) {
        top: -66.6666666667%;
        left: 66.6666666667%;
    }
    .la-ball-8bits > div:nth-child(4) {
        top: -33.3333333333%;
        left: 100%;
    }
    .la-ball-8bits > div:nth-child(5) {
        top: 0;
        left: 100%;
    }
    .la-ball-8bits > div:nth-child(6) {
        top: 33.3333333333%;
        left: 100%;
    }
    .la-ball-8bits > div:nth-child(7) {
        top: 66.6666666667%;
        left: 66.6666666667%;
    }
    .la-ball-8bits > div:nth-child(8) {
        top: 100%;
        left: 33.3333333333%;
    }
    .la-ball-8bits > div:nth-child(9) {
        top: 100%;
        left: 0;
    }
    .la-ball-8bits > div:nth-child(10) {
        top: 100%;
        left: -33.3333333333%;
    }
    .la-ball-8bits > div:nth-child(11) {
        top: 66.6666666667%;
        left: -66.6666666667%;
    }
    .la-ball-8bits > div:nth-child(12) {
        top: 33.3333333333%;
        left: -100%;
    }
    .la-ball-8bits > div:nth-child(13) {
        top: 0;
        left: -100%;
    }
    .la-ball-8bits > div:nth-child(14) {
        top: -33.3333333333%;
        left: -100%;
    }
    .la-ball-8bits > div:nth-child(15) {
        top: -66.6666666667%;
        left: -66.6666666667%;
    }
    .la-ball-8bits > div:nth-child(16) {
        top: -100%;
        left: -33.3333333333%;
    }
    .la-ball-8bits.la-sm {
        width: 6px;
        height: 6px;
    }
    .la-ball-8bits.la-sm > div {
        width: 2px;
        height: 2px;
    }
    .la-ball-8bits.la-2x {
        width: 24px;
        height: 24px;
    }
    .la-ball-8bits.la-2x > div {
        width: 8px;
        height: 8px;
    }
    .la-ball-8bits.la-3x {
        width: 36px;
        height: 36px;
    }
    .la-ball-8bits.la-3x > div {
        width: 12px;
        height: 12px;
    }
    /*
    * Animation
    */
    @-webkit-keyframes ball-8bits {
        0% {
            opacity: 1;
        }
        50% {
            opacity: 1;
        }
        51% {
            opacity: 0;
        }
    }
    @-moz-keyframes ball-8bits {
        0% {
            opacity: 1;
        }
        50% {
            opacity: 1;
        }
        51% {
            opacity: 0;
        }
    }
    @-o-keyframes ball-8bits {
        0% {
            opacity: 1;
        }
        50% {
            opacity: 1;
        }
        51% {
            opacity: 0;
        }
    }
    @keyframes ball-8bits {
        0% {
            opacity: 1;
        }
        50% {
            opacity: 1;
        }
        51% {
            opacity: 0;
        }
    }
 </style>
