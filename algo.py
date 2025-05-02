import pygame
import random
import time
import sys

# Initialize pygame
pygame.init()

# Constants
WIDTH, HEIGHT = 800, 600
BAR_WIDTH = 5
WHITE = (255, 255, 255)
BLACK = (0, 0, 0)
RED = (255, 0, 0)
GREEN = (0, 255, 0)
BLUE = (0, 0, 255)
FPS = 60

# Set up the display
screen = pygame.display.set_mode((WIDTH, HEIGHT))
pygame.display.set_caption("Sorting Algorithm Visualizer")
clock = pygame.time.Clock()

# Generate random data
def generate_data(size):
    return [random.randint(10, HEIGHT - 50) for _ in range(size)]

# Draw the bars
def draw_bars(data, color_positions={}):
    screen.fill(BLACK)
    for i, value in enumerate(data):
        color = WHITE
        if i in color_positions:
            color = color_positions[i]
        pygame.draw.rect(screen, color, (i * BAR_WIDTH, HEIGHT - value, BAR_WIDTH, value))
    pygame.display.update()

# Bubble Sort
def bubble_sort(data):
    n = len(data)
    for i in range(n):
        for j in range(0, n-i-1):
            # Visualize the comparison
            draw_bars(data, {j: RED, j+1: BLUE})
            time.sleep(0.01)
            
            if data[j] > data[j+1]:
                # Swap
                data[j], data[j+1] = data[j+1], data[j]
                # Visualize the swap
                draw_bars(data, {j: GREEN, j+1: GREEN})
                time.sleep(0.01)
    
    # Final visualization
    draw_bars(data)
    return data

# Merge Sort
def merge_sort(data, left=0, right=None, temp=None):
    if right is None:
        right = len(data) - 1
        temp = [0] * len(data)
    
    if left < right:
        mid = (left + right) // 2
        
        # Recursively sort both halves
        merge_sort(data, left, mid, temp)
        merge_sort(data, mid+1, right, temp)
        
        # Merge the sorted halves
        i, j, k = left, mid+1, left
        
        while i <= mid and j <= right:
            # Visualize the comparison
            draw_bars(data, {i: RED, j: BLUE})
            time.sleep(0.01)
            
            if data[i] <= data[j]:
                temp[k] = data[i]
                i += 1
            else:
                temp[k] = data[j]
                j += 1
            k += 1
        
        while i <= mid:
            temp[k] = data[i]
            i += 1
            k += 1
        
        while j <= right:
            temp[k] = data[j]
            j += 1
            k += 1
        
        # Copy back from temp to data
        for idx in range(left, right+1):
            data[idx] = temp[idx]
            # Visualize the update
            draw_bars(data, {idx: GREEN})
            time.sleep(0.005)
    
    return data

# Main function
def main():
    data_size = WIDTH // BAR_WIDTH
    data = generate_data(data_size)
    sorted_data = sorted(data)
    
    running = True
    sorting = False
    algorithm = bubble_sort  # Default algorithm
    
    while running:
        for event in pygame.event.get():
            if event.type == pygame.QUIT:
                running = False
            
            if not sorting:
                if event.type == pygame.KEYDOWN:
                    if event.key == pygame.K_r:
                        data = generate_data(data_size)
                        draw_bars(data)
                    elif event.key == pygame.K_1:
                        algorithm = bubble_sort
                    elif event.key == pygame.K_2:
                        algorithm = merge_sort
                    elif event.key == pygame.K_RETURN:
                        sorting = True
        
        if sorting:
            try:
                # Run the sorting algorithm
                next(algorithm(data))
            except StopIteration:
                sorting = False
                # Check if sorted correctly
                if data == sorted_data:
                    print("Sorted correctly!")
                else:
                    print("Sorting failed!")
        
        if not sorting:
            draw_bars(data)
        
        # Display instructions
        font = pygame.font.SysFont('Arial', 16)
        instructions = [
            "Press 1: Bubble Sort",
            "Press 2: Merge Sort",
            "Press R: Reset Data",
            "Press Enter: Start Sorting"
        ]
        
        for i, text in enumerate(instructions):
            text_surface = font.render(text, True, WHITE)
            screen.blit(text_surface, (10, 10 + i * 20))
        
        pygame.display.flip()
        clock.tick(FPS)
    
    pygame.quit()
    sys.exit()

if __name__ == "__main__":
    # Convert sorting functions to generators for visualization
    def bubble_sort(data):
        n = len(data)
        for i in range(n):
            for j in range(0, n-i-1):
                # Visualize the comparison
                draw_bars(data, {j: RED, j+1: BLUE})
                yield
                
                if data[j] > data[j+1]:
                    # Swap
                    data[j], data[j+1] = data[j+1], data[j]
                    # Visualize the swap
                    draw_bars(data, {j: GREEN, j+1: GREEN})
                    yield
    
    def merge_sort(data, left=0, right=None, temp=None):
        if right is None:
            right = len(data) - 1
            temp = [0] * len(data)
        
        if left < right:
            mid = (left + right) // 2
            
            # Recursively sort both halves
            yield from merge_sort(data, left, mid, temp)
            yield from merge_sort(data, mid+1, right, temp)
            
            # Merge the sorted halves
            i, j, k = left, mid+1, left
            
            while i <= mid and j <= right:
                # Visualize the comparison
                draw_bars(data, {i: RED, j: BLUE})
                yield
                
                if data[i] <= data[j]:
                    temp[k] = data[i]
                    i += 1
                else:
                    temp[k] = data[j]
                    j += 1
                k += 1
            
            while i <= mid:
                temp[k] = data[i]
                i += 1
                k += 1
            
            while j <= right:
                temp[k] = data[j]
                j += 1
                k += 1
            
            # Copy back from temp to data
            for idx in range(left, right+1):
                data[idx] = temp[idx]
                # Visualize the update
                draw_bars(data, {idx: GREEN})
                yield
    
    main()