// Javascript Document
(() => {
  return {
    data(){
      return {
        radios: [
          {
            name: "FIP Live",
            src: "https://icecast.radiofrance.fr/fip-midfi.mp3",
          }, {
            name: "FIP Electro",
            src: "https://icecast.radiofrance.fr/fipelectro-midfi.mp3",
          }, {
            name: "FIP Rock",
            src: "https://icecast.radiofrance.fr/fiprock-midfi.mp3",
          }, {
            name: "FIP Jazz",
            src: "https://icecast.radiofrance.fr/fipjazz-midfi.mp3",
          }, {
            name: "FIP Groove",
            src: "https://icecast.radiofrance.fr/fipgroove-midfi.mp3",
          }, {
            name: "FIP World",
            src: "https://icecast.radiofrance.fr/fipworld-midfi.mp3",
          }, {
            name: "FIP New",
            src: "https://icecast.radiofrance.fr/fipnouveautes-midfi.mp3",
          }, {
            name: "FIP Reggae",
            src: "https://icecast.radiofrance.fr/fipreggae-midfi.mp3",
          }, {
            name: "France Inter",
            src: "https://direct.franceinter.fr/live/franceinter-midfi.mp3",
          }, {
            name: "Le Mouv'",
            src: "https://direct.mouv.fr/live/mouv-midfi.mp3",
          }, {
            name: "Radio Meuh",
            src: "https://radiomeuh.ice.infomaniak.ch/radiomeuh-128.mp3"
          }
        ]
      }
    },
    methods: {
      reset(cp){
        let audio = cp.find('bbn-audio');
        if ( audio ){
          audio.pause();
          audio.widget.currentTime = 0;
          audio.play();
        }
      },
      onPlay(e){
        bbn.fn.each(this.findAll('bbn-audio'), a => {
          if ( a.widget !== e.target ){
            a.pause();
          }
        })
      }
    },
    mounted(){
      if ( !bbn.fn.onAudio ){
        bbn.fn.onAudio = (e) => {
        };
      }
    },
  };
})();