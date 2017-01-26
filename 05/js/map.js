(function( w, r ) {
    w['r'+r] = w['r'+r] || w['webkitR'+r] || w['mozR'+r] || w['msR'+r] || w['oR'+r] || function(c){ w.setTimeout(c, 1000 / 60); };
})( this, 'equestAnimationFrame' );

google.load( 'maps', 3, {
    'other_params' : 'sensor=false&libraries=panoramio'
});


google.setOnLoadCallback(function() {
    
    var mapName = '家守綺譚マップ', gmap, sakura;
    // Google Map 
    gmap = {
        mapOptions: {
            center: new google.maps.LatLng( 34.992870, 135.820235 ),
            mapTypeControlOptions: {
                'mapTypeIds' : [ mapName, google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.SATELLITE ],
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
            },
			
            mapTypeId: mapName,
            streetViewControl: false,
            scrollWheel: false,
            zoom: 15,
            maxZoom: 15,
            minZoom: 15
        },
        initialize: function() {
			 
            var self = this,
                mapDiv = document.getElementById( 'map' ),
                getSize = function() {
                    return document.documentElement.clientWidth || document.body.clientWidth;
                },
                jsdoCanvas = 565,
                timeout;
			
            
            // サイズ設定 
            this.fitSize( getSize() !== jsdoCanvas ? getSize() : jsdoCanvas, mapDiv );
            
            // MAP作成 
            this.map = new google.maps.Map( mapDiv, this.mapOptions );
            
            // MAPへカスタムカラーをセット 
            this.map.mapTypes.set(
                mapName,
                new google.maps.StyledMapType(
                    this.mapStyles,
                    { name: mapName }
                )
            );
            
            this.createTree();
            this.addCanvas();
        	
            google.maps.event.addDomListener( window, 'resize', function() {
                window.clearTimeout( timeout );
                timeout = window.setTimeout(function() {
                    self.fitSize( getSize(), mapDiv );
                }, 400 );
            });
        },
		

        // ウィンドウサイズに合わせる 
        fitSize: function( size, mapDiv ) {
            this.width = size;
            this.height = size;
            mapDiv.style.width = size + 'px';
            mapDiv.style.height = size + 'px';
            
            // Canvas関連 
            sakura.width = size;
            sakura.height = size;
            
            if ( this.overlay && this.overlay.canvas ) {
                this.overlay.canvas.width = size;
                this.overlay.canvas.height = size;
            }
        },
       
        // 座標
        createTree: function() {
            var self = this,
                duration = 200;
            
            this.marker = [];
            this.info = [];
            
            for ( var i = -1, l = this.list.length;  ++i < l; ) {
                (function() {
                    var num = i;
					
                    // マーカ追加 
                    setTimeout(function() {
                        self.marker[num] = new google.maps.Marker({
                            position: new google.maps.LatLng( self.list[num].lat, self.list[num].lng ),
                            map: self.map, 
                            title: self.list[num].status,
                            icon: new google.maps.MarkerImage(
                                self.list[num].icon,
                                new google.maps.Size( 50, 50 ),
                                new google.maps.Point( 0, 0 ),
                                new google.maps.Point( 25, 25 )
                            ),
                            animation: google.maps.Animation.DROP
                        });
                        
                        // マーカークリック 
                        google.maps.event.addListener( self.marker[num], 'click', function() {
                            // センターへ移動 
                            self.map.panTo(
                                new google.maps.LatLng(
                                    this.position.lat(),
                                    this.position.lng()
                                )
                            );
                            
                            // 情報表示 
                            self.info[num].open( self.map, self.marker[num] );
                        });
                    }, ( num + 1 ) * duration );
                    
                    // 情報追加 
                    self.info[num] = new google.maps.InfoWindow({
                        content: [
                            '<div style="font-size: 16px; border-bottom: solid 1px #ccc; padding: 5px 0 5px 0;">',
                                self.list[num].name,
                            '</div>',
							'<div style="font-size: 13px; padding: 0 0 5px 0;">',
                                '<br>' + self.list[num].txt + '<br>',
                            '</div>'
                        ].join( '' )
                    });
                })();
            }
        },
        // Canvasオーバーレイヤー 
        addCanvas: function() {
            var self = this, queue;
            
            (function() {
                if ( self.map.getBounds() ) {
                    // Canvas追加 
                    self.overlay = new overlay( self.map );
                    
                    // canvas位置調整 
                    google.maps.event.addListener( self.map, 'bounds_changed', function() {
                        window.clearTimeout( queue );
                        queue = window.setTimeout(function() {
                            self.overlay.draw();
                        }, 200 );
                    });
                    
                    return;
                }
                
                window.setTimeout( arguments.callee, 100 );
            })();
        },
        // 地図座標
        list: [
            {
                name: '余呉湖',
                txt:  '天女の羽衣伝説がある。',
				icon: 'http://www.design-100.com/ebisawa/gs/icon01.png',
                lat: 35.524319,
                lng: 136.193429
            },
            {
                name: '萩の浜',
                txt:  '（推定）<br>高堂がボートを漕いでいた場所',
				icon: 'http://www.design-100.com/ebisawa/gs/icon10.png',
                lat: 35.298962,
                lng: 136.024622
            },
            {
                name: '朽木',
                txt:  '（推定）<br>ゴローが河童を送っていった。',
				icon: 'http://www.design-100.com/ebisawa/gs/icon04.png',
                lat: 35.353571,
                lng: 135.922452
            },
            {
                name: '綿貫征四郎の家（高堂の実家）',
                txt:  '物語の舞台になる。',
				icon: 'http://www.design-100.com/ebisawa/gs/icon13.png',
                lat: 34.992870,
                lng: 135.820235
            },
            {
                name: '竹生島',
                txt:  '竹生島神社 (http://www.chikubusima.or.jp/)<br>浅井姫命を祀る。<br>高堂のボートが見つかった場所',
				icon: 'http://www.design-100.com/ebisawa/gs/icon11.png',
                lat: 35.422406,
                lng: 136.143991
            },
            {
                name: '人康親王御陵 / 十禅寺',
                txt:  '仁明天皇の第四王子で琵琶の名手を祀る。<br><br>「人康親王といって、（～中略～）の小さな御陵があるんです」（肉屋の主人）',
				icon: 'http://www.design-100.com/ebisawa/gs/icon12.png',
                lat: 34.992418,
                lng: 135.821892
            },
            {
                name: '毘沙門堂',
                txt:  '七福神の一人、毘沙門天を本尊とする。<br><br>「百足封じのお札はそこの毘沙門さんで売っているけれど」（隣のおかみさん）',
				icon: 'http://www.design-100.com/ebisawa/gs/icon12.png',
                lat: 35.001685,
                lng: 135.818714
            },
            {
                name: '小関越え',
                txt:  '山科と大津を結ぶ峠道。東海道の大関越え（逢坂の関）の裏道<br><br>和尚の寺の竹藪に筍を探して上ってきたが、見つからないのでどこまでも丘を上っていくと湖が見えた。<br>「これより南には街道で一番大きな関所があり、（～中略～）その少し北の小関越えをして東と西を行き来していたと聞いたことがある。考えればそれがこの辺りのはずだ」',
				icon: 'http://www.design-100.com/ebisawa/gs/icon06.png',
                lat: 35.006059,
                lng: 135.850442
            },
			{
                name: '牛尾山',
                txt:  '桜ノ馬場の分岐点<br><br>「街道を越して家の東南の方角に位置する牛尾山を目指す」<br>「やがて山頂とおぼしき野原に出る。立て札あり、このまま醍醐寺の奥の院まで出ることも可、また音羽山を湖の方へ回り、石山寺まで行くも可」',
				icon: 'http://www.design-100.com/ebisawa/gs/icon09.png',
                lat: 34.969071,
                lng: 135.847352
            },
			{
                name: '吉田神社',
                txt:  '吉田神社 (http://www5.ocn.ne.jp/~yosida/)<br><br>魔除けの札を手に入れに行く。',
				icon: 'http://www.design-100.com/ebisawa/gs/icon11.png',
                lat: 35.025691,
                lng: 135.783453
            },
			{
                name: '一乗寺　狸谷不動山',
                txt:  '狸谷山不動院 (http://www.tanukidani.com/top.html)<br><br>和尚に化けた狸がお山と言った場所',
				icon: 'http://www.design-100.com/ebisawa/gs/icon08.png',
                lat: 35.041554,
                lng: 135.801089
            },
			{
                name: '坂本　日吉神社',
                txt:  '日吉大社 (http://hiyoshitaisha.jp/)<br>龍田姫は浅井姫命へ挨拶の後に渡る。',
				icon: 'http://www.design-100.com/ebisawa/gs/icon11.png',
                lat: 35.072915,
                lng: 135.865010
            },
			{
                name: '清滝',
                txt:  '河童の十三参り',
				icon: 'http://www.design-100.com/ebisawa/gs/icon04.png',
                lat: 35.038236,
                lng: 135.657868
            },
            {
                name: '音羽山',
                txt:  '音羽山',
				icon: 'http://www.design-100.com/ebisawa/gs/icon06.png',
                lat: 34.977159,
                lng: 135.853102
            }
        ],
        // カラー設定 
        mapStyles: [
            {
                elementType: 'geometry',
                featureType: 'all',
                stylers: [
                    { lightness: 40 },
                    { saturation: -80 }
                ]
            },
            {
                elementType: 'geometry',
                featureType: 'road',
                stylers: [
                    { lightness: 100 },
                    { saturation: -100 }
                ]
            },
            {
                elementType: 'geometry',
                featureType: 'water',
                stylers: [
                    { lightness: 20 },
                    { saturation: 100 }
                ]
            },
            {
                elementType: 'labels',
                featureType: 'all',
                stylers: [
                    { visibility: 'on' }
                ]
            }
        ]
    };
    
	
	
    // Canvasオーバーレイヤー追加 
    function overlay( map ) {
        this.map = map;
        this.div = null;
        this.canvas = null;
        this.setMap( map );
    }
    overlay.prototype.onAdd = function() {
        // div 
        this.div = document.createElement( 'div' );
        this.div.style.position = 'absolute';
        
        // canvas 
        this.canvas = document.createElement( 'canvas' );
        this.canvas.id = 'sakura';
        this.canvas.width = gmap.width;
        this.canvas.height = gmap.height;
        
        // DOMへ追加 
        this.div.appendChild( this.canvas );
        this.getPanes().overlayImage.appendChild( this.div );
        
        sakura.init();
    };
    overlay.prototype.draw = function() {
        var projection = this.getProjection(),
            sw = projection.fromLatLngToDivPixel( this.map.getBounds().getSouthWest() ),
            ne = projection.fromLatLngToDivPixel( this.map.getBounds().getNorthEast() );
        
        this.div.style.left = sw.x + 'px';
        this.div.style.top = ne.y + 'px';
        this.div.style.width = ( ne.x - sw.x ) + 'px';
        this.div.style.height = ( sw.y - ne.y ) + 'px';
    };
    overlay.prototype.onRemove = function() {
        this.div.parentNode.removeChild( this.div );
    };
    // 花びらが舞うエフェクト 
    sakura = {
        img: new Image(),
        imgPath: 'http://www.design-100.com/ebisawa/gs/blue.png',
        canvas: null,
        ctx: null,
        width: null,
        height: null,
        petals: [],
        petalCount: 30,
        radians: 180 / Math.PI,
        init: function() {
            var self = this;
            
            this.canvas = document.getElementById( 'sakura' );
            this.ctx = this.canvas.getContext( '2d' );
            
            this.img.src = this.imgPath;
            this.img.onload = function() {
                self.play();
            };
        },
        play: function() {
            var self = this;
            
            for ( var i = -1;  ++i < this.petalCount; ) {
                this.petals[i] = new petal( this );
            }
            
            this.frame = 0;
            //this.ctx.shadowBlur = 5;
            //this.ctx.shadowColor = 'rgb( 255, 0, 255 )';
            //this.ctx.globalCompositeOperation = 'lighter';
            
            (function() {
                self.frame++;
                self.ctx.clearRect( 0, 0, self.width, self.height );
                
                for ( var i = -1, petal;  ++i < self.petalCount; ) {
                    petal = self.petals[i];
                    
                    self.ctx.save();
                    self.ctx.translate( petal.x, petal.y );
                    self.ctx.rotate( petal.degY / self.radians );
                    self.ctx.scale( 1, 1 *  Math.cos( petal.degX / self.radians ) );
                    self.ctx.drawImage( self.img, 0, 0, petal.width, petal.height );
                    self.ctx.restore();
                    
                    petal.update( self );
                }
                
                window.requestAnimationFrame( arguments.callee );
            })();
        }
    };
    // 花びらオブジェ 
    function petal( obj ) {
        this.width = 20;
        this.height = 20;
        this.scale = 1;
        this.x = Math.random() * obj.width;
        this.y = Math.random() * obj.height;
        this.degX = Math.floor( Math.random() * 360 );
        this.degY = Math.floor( Math.random() * 360 );
        this.speedX = Math.random() * 1;
        this.speedY = 0.5 + Math.random() * 1;
    }
    petal.prototype = {
        shake: {
            cycle: 100,
            right: 2,
            left: -2,
            step: 0.1
        },
        update: function( obj ) {
            this.y += this.speedY;
            this.x += this.speedX;
            this.degX += 1 + Math.floor( Math.sin( obj.frame ) );
            this.degY += 1 + Math.floor( Math.sin( obj.frame ) );
            
            // 左右に揺らす 
            if ( this.y % this.shake.cycle * 2 > this.shake.cycle ) {
                if ( this.speedX > this.shake.left ) {
                    this.speedX -= this.shake.step;
                }
            } else {
                if ( this.speedX < this.shake.right ) {
                    this.speedX += this.shake.step;
                }
            }
            
            // x,y座標上限 
            if ( this.x > obj.width || this.x < 0 || this.y > obj.height ) {
                this.restart( obj );
            }
        },
        restart: function( obj ) {
            this.x = Math.random() * obj.width;
            this.y = 0;
        }
    };
	
   gmap.initialize();
});