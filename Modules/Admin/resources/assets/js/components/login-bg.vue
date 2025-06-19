<template>
    <div class="flying-shapes-wrapper">
        <div class="flying-shapes-container">
            <canvas ref="canvas"></canvas>
        </div>
    </div>
</template>

<script>
import { onMounted, ref, onUnmounted, watchEffect } from 'vue';

export default {
    name: 'FlyingShapesBackground',
    props: {
        shapeCount: {
            type: Number,
            default: 30
        },
        animationSpeed: {
            type: Number,
            default: 0.5
        },
        fadeDistance: {
            type: Number,
            default: 100
        }
    },
    setup(props) {
        const canvas = ref(null);
        let ctx = null;
        let animationFrameId = null;
        let shapes = [];
        let containerWidth = 0;
        let containerHeight = 0;
        let resizeObserver = null;

        // 形状配置
        const shapesConfig = {
            colors: [
                '#3498db', '#e74c3c', '#2ecc71', '#f39c12', '#9b59b6',
                '#1abc9c', '#d35400', '#27ae60', '#8e44ad', '#c0392b'
            ],
            types: ['circle', 'square', 'triangle', 'star']
        };

        // 创建形状
        const createShape = () => {
            const type = shapesConfig.types[Math.floor(Math.random() * shapesConfig.types.length)];
            const size = Math.random() * 20 + 10; // 10-30px
            const colorIndex = Math.floor(Math.random() * shapesConfig.colors.length);
            const color = shapesConfig.colors[colorIndex];

            // 随机初始位置（整个屏幕范围内）
            const startX = Math.random() * containerWidth;
            const startY = Math.random() * containerHeight;

            // 随机速度和方向
            const angle = Math.random() * Math.PI * 2;
            const speed = (Math.random() * 0.8 + 0.5) * props.animationSpeed;
            const speedX = Math.cos(angle) * speed;
            const speedY = Math.sin(angle) * speed;

            const rotation = Math.random() * Math.PI * 2;
            const rotationSpeed = (Math.random() - 0.5) * 0.02 * props.animationSpeed;
            const colorChangeRate = Math.random() * 0.01;
            let targetColorIndex = (colorIndex + 1) % shapesConfig.colors.length;
            let colorProgress = 0;

            // 初始不透明度
            let opacity = 1;
            let fadeState = 'none'; // none, fadingIn, fadingOut

            return {
                type,
                x: startX,
                y: startY,
                size,
                speedX,
                speedY,
                rotation,
                rotationSpeed,
                color,
                colorIndex,
                targetColorIndex,
                colorProgress,
                colorChangeRate,
                opacity,
                fadeState,
                update() {
                    // 更新位置
                    this.x += this.speedX;
                    this.y += this.speedY;
                    this.rotation += this.rotationSpeed;

                    // 更新颜色
                    this.colorProgress += this.colorChangeRate;
                    if (this.colorProgress >= 1) {
                        this.colorProgress = 0;
                        this.colorIndex = this.targetColorIndex;
                        this.targetColorIndex = (this.targetColorIndex + 1) % shapesConfig.colors.length;
                    }

                    // 计算渐变颜色
                    const currentColor = shapesConfig.colors[this.colorIndex];
                    const targetColor = shapesConfig.colors[this.targetColorIndex];
                    this.color = interpolateColors(currentColor, targetColor, this.colorProgress);

                    // 处理淡入淡出
                    this.handleFade();

                    // 完全透明时重置位置
                    if (this.opacity <= 0 && this.fadeState === 'fadingOut') {
                        this.resetPosition();
                        this.fadeState = 'fadingIn';
                    }

                    // 完全显示后停止淡入
                    if (this.opacity >= 1 && this.fadeState === 'fadingIn') {
                        this.fadeState = 'none';
                        this.opacity = 1;
                    }
                },
                handleFade() {
                    // 计算到最近边界的距离
                    const distanceToEdge = Math.min(
                        this.x,
                        containerWidth - this.x,
                        this.y,
                        containerHeight - this.y
                    );

                    // 根据距离计算透明度
                    if (distanceToEdge < props.fadeDistance) {
                        this.fadeState = 'fadingOut';
                        this.opacity = distanceToEdge / props.fadeDistance;
                    } else if (this.fadeState === 'fadingIn') {
                        this.opacity += 0.02;
                        this.opacity = Math.min(1, this.opacity);
                    }
                },
                resetPosition() {
                    // 重置到屏幕内的随机位置和方向
                    this.x = Math.random() * containerWidth;
                    this.y = Math.random() * containerHeight;

                    const angle = Math.random() * Math.PI * 2;
                    const speed = (Math.random() * 0.8 + 0.5) * props.animationSpeed;
                    this.speedX = Math.cos(angle) * speed;
                    this.speedY = Math.sin(angle) * speed;

                    // 重置颜色
                    this.colorIndex = Math.floor(Math.random() * shapesConfig.colors.length);
                    this.targetColorIndex = (this.colorIndex + 1) % shapesConfig.colors.length;
                    this.colorProgress = 0;

                    // 开始淡入
                    this.opacity = 0;
                    this.fadeState = 'fadingIn';
                },
                draw() {
                    ctx.save();
                    ctx.translate(this.x, this.y);
                    ctx.rotate(this.rotation);

                    // 应用透明度
                    const rgbaColor = hexToRgba(this.color, this.opacity);
                    ctx.fillStyle = rgbaColor;

                    switch (this.type) {
                        case 'circle':
                            ctx.beginPath();
                            ctx.arc(0, 0, this.size / 2, 0, Math.PI * 2);
                            ctx.fill();
                            break;
                        case 'square':
                            ctx.fillRect(-this.size / 2, -this.size / 2, this.size, this.size);
                            break;
                        case 'triangle':
                            ctx.beginPath();
                            ctx.moveTo(0, -this.size / 2);
                            ctx.lineTo(this.size / 2, this.size / 2);
                            ctx.lineTo(-this.size / 2, this.size / 2);
                            ctx.closePath();
                            ctx.fill();
                            break;
                        case 'star':
                            drawStar(ctx, 0, 0, 5, this.size / 2, this.size / 4);
                            break;
                    }

                    ctx.restore();
                }
            };
        };

        // 绘制星形
        const drawStar = (ctx, cx, cy, spikes, outerRadius, innerRadius) => {
            let rot = Math.PI / 2 * 3;
            let x = cx;
            let y = cy;
            let step = Math.PI / spikes;

            ctx.beginPath();
            ctx.moveTo(cx, cy - outerRadius);

            for (let i = 0; i < spikes; i++) {
                x = cx + Math.cos(rot) * outerRadius;
                y = cy + Math.sin(rot) * outerRadius;
                ctx.lineTo(x, y);
                rot += step;

                x = cx + Math.cos(rot) * innerRadius;
                y = cy + Math.sin(rot) * innerRadius;
                ctx.lineTo(x, y);
                rot += step;
            }

            ctx.lineTo(cx, cy - outerRadius);
            ctx.closePath();
            ctx.fill();
        };

        // 颜色插值
        const interpolateColors = (color1, color2, factor) => {
            const hex1 = color1.replace('#', '');
            const hex2 = color2.replace('#', '');

            const r1 = parseInt(hex1.substring(0, 2), 16);
            const g1 = parseInt(hex1.substring(2, 4), 16);
            const b1 = parseInt(hex1.substring(4, 6), 16);

            const r2 = parseInt(hex2.substring(0, 2), 16);
            const g2 = parseInt(hex2.substring(2, 4), 16);
            const b2 = parseInt(hex2.substring(4, 6), 16);

            const r = Math.round(r1 + factor * (r2 - r1));
            const g = Math.round(g1 + factor * (g2 - g1));
            const b = Math.round(b1 + factor * (b2 - b1));

            return `#${padZero(r.toString(16))}${padZero(g.toString(16))}${padZero(b.toString(16))}`;
        };

        // 辅助函数：补零
        const padZero = (str, len = 2) => {
            const zeros = new Array(len).join('0');
            return (zeros + str).slice(-len);
        };

        // 辅助函数：十六进制转RGBA
        const hexToRgba = (hex, alpha) => {
            const r = parseInt(hex.substring(1, 3), 16);
            const g = parseInt(hex.substring(3, 5), 16);
            const b = parseInt(hex.substring(5, 7), 16);

            return `rgba(${r}, ${g}, ${b}, ${alpha})`;
        };

        // 初始化画布
        const initCanvas = () => {
            if (!canvas.value) return;

            ctx = canvas.value.getContext('2d');

            // 设置高DPI支持
            updateCanvasSize();

            // 清空形状数组并创建新形状
            shapes = [];
            for (let i = 0; i < props.shapeCount; i++) {
                shapes.push(createShape());
            }
        };

        // 更新画布尺寸
        const updateCanvasSize = () => {
            if (!canvas.value) return;

            const dpr = window.devicePixelRatio || 1;
            containerWidth = canvas.value.parentElement.clientWidth;
            containerHeight = canvas.value.parentElement.clientHeight;

            canvas.value.width = containerWidth * dpr;
            canvas.value.height = containerHeight * dpr;

            ctx.scale(dpr, dpr);

            // 清空画布
            ctx.clearRect(0, 0, containerWidth, containerHeight);
        };

        // 动画循环
        const animate = () => {
            if (!ctx) return;

            // 清空画布
            ctx.clearRect(0, 0, containerWidth, containerHeight);

            // 更新和绘制所有形状
            shapes.forEach(shape => {
                shape.update();
                shape.draw();
            });

            // 继续动画
            animationFrameId = requestAnimationFrame(animate);
        };

        // 响应窗口大小变化
        const handleResize = () => {
            updateCanvasSize();

            // 调整形状位置，防止它们超出新的边界
            shapes.forEach(shape => {
                if (shape.x > containerWidth) shape.x = containerWidth;
                if (shape.y > containerHeight) shape.y = containerHeight;
            });
        };

        // 清理
        const cleanup = () => {
            if (animationFrameId) {
                cancelAnimationFrame(animationFrameId);
            }
            if (resizeObserver) {
                resizeObserver.disconnect();
            }
            window.removeEventListener('resize', handleResize);
        };

        onMounted(() => {
            initCanvas();
            animate();

            // 添加窗口大小变化监听
            window.addEventListener('resize', handleResize);

            // 添加容器大小变化监听
            resizeObserver = new ResizeObserver(handleResize);
            if (canvas.value) {
                resizeObserver.observe(canvas.value.parentElement);
            }
        });

        onUnmounted(cleanup);

        // 监听props变化
        watchEffect(() => {
            if (ctx) {
                // 调整形状数量
                if (shapes.length < props.shapeCount) {
                    const countToAdd = props.shapeCount - shapes.length;
                    for (let i = 0; i < countToAdd; i++) {
                        shapes.push(createShape());
                    }
                } else if (shapes.length > props.shapeCount) {
                    shapes.splice(props.shapeCount);
                }

                // 调整动画速度
                shapes.forEach(shape => {
                    const angle = Math.atan2(shape.speedY, shape.speedX);
                    const speed = Math.sqrt(shape.speedX * shape.speedX + shape.speedY * shape.speedY);
                    const newSpeed = (speed / (props.animationSpeed || 1)) * props.animationSpeed;

                    shape.speedX = Math.cos(angle) * newSpeed;
                    shape.speedY = Math.sin(angle) * newSpeed;
                    shape.rotationSpeed = (Math.random() - 0.5) * 0.02 * props.animationSpeed;
                });
            }
        });

        return {
            canvas
        };
    }
};
</script>

<style scoped>
.flying-shapes-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    overflow: hidden;
    pointer-events: none;
    z-index: 0;
}

.flying-shapes-container {
    width: 100%;
    height: 100%;
}

canvas {
    display: block;
    width: 100%;
    height: 100%;
}
</style>