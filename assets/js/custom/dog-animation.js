
const {
	body
} = document;
const fullWidth = body.clientWidth;
const fullHeight = body.clientHeight;

const {
	fromEvent
} = rxjs;
const {
	map
} = rxjs.operators;

const mouseMove$ = fromEvent(body, "mousemove");

const mouseXY$ = mouseMove$.pipe(
	map(({
		offsetX,
		offsetY
	}) => ({
		x: offsetX / fullWidth,
		y: offsetY / fullHeight
	}))
);

mouseXY$.subscribe(({
	x,
	y
}) => {
	body.style.setProperty("--mouse-x", x);
	body.style.setProperty("--mouse-y", y);
});