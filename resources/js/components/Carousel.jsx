import { default as Slider } from "react-slick";
import { arr } from "../assets/imageExport"


const Carousel = () => {
    const SliderComponent = Slider.default || Slider;
    var settings = {
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        speed: 3000,
        autoplaySpeed: 3000,
        adaptiveHeight: true,
        cssEase: "ease-in"
    };
    return (
        <div className='max-w-[90%] mx-auto'>
            <SliderComponent {...settings}>
                {arr.map((image, index) => (
                    <div key={index}>
                        <img 
                            src={image} 
                            alt={`Slide ${index + 1}`} 
                            className="w-full h-auto" 
                        />
                    </div>
                ))}
            </SliderComponent>
        </div>
    );
}

export default Carousel
